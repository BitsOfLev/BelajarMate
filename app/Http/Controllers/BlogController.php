<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
     use AuthorizesRequests;
     
    /**
     * Display all approved blogs (main feed)
     * Can filter by: friends-only, category
     */
    public function feed(Request $request)
    {
        $query = Blog::with(['user', 'category', 'likes', 'comments'])
            ->approved()
            ->latest('posted_at');

        // Filter: Friends only
        if ($request->filter === 'friends') {
            $query->fromFriends(Auth::id());
        }

        // Filter: By category
        if ($request->category) {
            $query->where('categoryID', $request->category);
        }

        $blogs = $query->paginate(12);
        $categories = BlogCategory::all();

        return view('blog.feed', compact('blogs', 'categories'));
    }

    /**
     * Display user's own blogs (My Blogs)
     */
    public function index()
    {
        $blogs = Blog::where('userID', Auth::id())
            ->with(['category', 'likes', 'comments'])
            ->latest('posted_at')
            ->get();
        
        return view('blog.index', compact('blogs'));
    }

    /**
     * Display blogs liked by the user
     */
    public function liked()
    {
        $blogs = Blog::whereHas('likes', function ($query) {
            $query->where('userID', Auth::id());
        })
        ->with(['user', 'category', 'likes', 'comments'])
        ->approved()
        ->latest('posted_at')
        ->paginate(12);

        $categories = BlogCategory::all();

        return view('blog.liked', compact('blogs', 'categories'));
    }

    /**
     * Show form to create a new blog
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('blog.create', compact('categories'));
    }

    /**
     * Store a new blog with moderation
     * - Banned words detection
     * - Image upload triggers pending status
     * - Default image assigned if no upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'blogTitle' => 'required|string|max:255',
            'blogContent' => 'required|string',
            'categoryID' => 'required|exists:blog_categories,categoryID',
            'blogImg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgPath = null;
        $needsReview = false;
        
        if ($request->hasFile('blogImg')) {
            // User uploaded custom image - needs review
            $imgPath = $request->file('blogImg')->store('blogs', 'public');
            $needsReview = true;
        } else {
            // No image uploaded - use default (no review needed)
            $imgPath = 'blog-default.jpg';
        }

        // Banned words moderation
        $bannedWords = $this->getBannedWords();
        $foundWords = $this->detectBannedWords($request->blogTitle . ' ' . $request->blogContent, $bannedWords);

        // Determine status: pending if has banned words OR has custom uploaded image
        if (!empty($foundWords)) {
            $needsReview = true;
        }
        
        $status = $needsReview ? Blog::STATUS_PENDING : Blog::STATUS_APPROVED;
        
        // Build flag reason
        $flagReasons = [];
        if (!empty($foundWords)) {
            $flagReasons[] = 'Detected banned words: ' . implode(', ', $foundWords);
        }
        if ($request->hasFile('blogImg')) {
            $flagReasons[] = 'Contains uploaded image - requires review';
        }
        $flagReason = !empty($flagReasons) ? implode(' | ', $flagReasons) : null;

        Blog::create([
            'userID' => Auth::id(),
            'categoryID' => $request->categoryID,
            'blogTitle' => $request->blogTitle,
            'blogContent' => $request->blogContent,
            'blogImg' => $imgPath,
            'posted_at' => now(),
            'status' => $status,
            'flag_reason' => $flagReason,
        ]);

        // Alert user if blog needs review
        if ($needsReview) {
            $message = 'Your blog has been submitted for admin review. ';
            if (!empty($foundWords)) {
                $message .= 'It contains words that require moderation. ';
            }
            if ($request->hasFile('blogImg')) {
                $message .= 'Posts with uploaded images require approval before being published.';
            }
            return redirect()->route('blog.index')->with('warning', $message);
        }

        return redirect()->route('blog.index')->with('success', 'Blog created successfully!');
    }

    /**
     * Show a single blog
     */
    public function show(Blog $blog)
    {
        // Only show approved blogs, or own blogs (even if pending)
        if ($blog->status !== Blog::STATUS_APPROVED && $blog->userID !== Auth::id()) {
            abort(403, 'This blog is not available.');
        }

        $blog->load(['user', 'category', 'likes', 'comments.user']);
        
        return view('blog.show', compact('blog'));
    }

    /**
     * Show form to edit a blog
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        $categories = BlogCategory::all();
        return view('blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update an existing blog with moderation
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $request->validate([
            'blogTitle' => 'required|string|max:255',
            'blogContent' => 'required|string',
            'categoryID' => 'required|exists:blog_categories,categoryID',
            'blogImg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgPath = $blog->blogImg; // Keep existing image by default
        $needsReview = false;
        
        if ($request->hasFile('blogImg')) {
            // User uploaded NEW custom image - needs review
            
            // Delete old image ONLY if it's not the default
            if ($blog->blogImg && $blog->blogImg !== 'blog-default.jpg') {
                Storage::disk('public')->delete($blog->blogImg);
            }
            
            $imgPath = $request->file('blogImg')->store('blogs', 'public');
            $needsReview = true;
        }
        // If no new image uploaded, keep existing image (could be default or custom)

        // Banned words moderation
        $bannedWords = $this->getBannedWords();
        $foundWords = $this->detectBannedWords($request->blogTitle . ' ' . $request->blogContent, $bannedWords);

        // Determine status: pending if has banned words OR has new uploaded image
        if (!empty($foundWords)) {
            $needsReview = true;
        }
        
        // Also check if current image is custom (not default) and blog was pending
        if ($imgPath !== 'blog-default.jpg' && $blog->status === Blog::STATUS_PENDING) {
            $needsReview = true;
        }
        
        $status = $needsReview ? Blog::STATUS_PENDING : Blog::STATUS_APPROVED;
        
        // Build flag reason
        $flagReasons = [];
        if (!empty($foundWords)) {
            $flagReasons[] = 'Detected banned words: ' . implode(', ', $foundWords);
        }
        if ($request->hasFile('blogImg') || ($imgPath !== 'blog-default.jpg' && $needsReview)) {
            $flagReasons[] = 'Contains uploaded image - requires review';
        }
        $flagReason = !empty($flagReasons) ? implode(' | ', $flagReasons) : null;

        $blog->update([
            'blogTitle' => $request->blogTitle,
            'blogContent' => $request->blogContent,
            'categoryID' => $request->categoryID,
            'blogImg' => $imgPath,
            'posted_at' => now(),
            'status' => $status,
            'flag_reason' => $flagReason,
        ]);

        // Alert user if blog needs review
        if ($needsReview) {
            $message = 'Your blog has been submitted for admin review. ';
            if (!empty($foundWords)) {
                $message .= 'It contains words that require moderation. ';
            }
            if ($request->hasFile('blogImg') || $imgPath !== 'blog-default.jpg') {
                $message .= 'Posts with uploaded images require approval before being published.';
            }
            return redirect()->route('blog.index')->with('warning', $message);
        }

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Delete a blog
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        // Delete image ONLY if it's not the default
        if ($blog->blogImg && $blog->blogImg !== 'blog-default.jpg') {
            Storage::disk('public')->delete($blog->blogImg);
        }

        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
    }

    /**
     * Helper: Get all banned words as flat array
     */
    private function getBannedWords()
    {
        return array_merge(...array_values(config('bannedwords.words')));
    }

    /**
     * Helper: Detect banned words in content
     */
    private function detectBannedWords($content, $bannedWords)
    {
        $foundWords = [];
        $content = strtolower($content);

        foreach ($bannedWords as $word) {
            // Use word boundaries to match whole words only
            $pattern = '/\b' . preg_quote(strtolower($word), '/') . '\b/';
            if (preg_match($pattern, $content)) {
                $foundWords[] = $word;
            }
        }

        return array_unique($foundWords);
    }
}

