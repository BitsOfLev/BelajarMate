<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BlogCommentNotification;

class CommentsController extends Controller
{
    /**
     * Store a new comment with banned words moderation
     */
    public function store(Request $request, Blog $blog)
    {
        // Only allow comments on approved blogs
        if ($blog->status !== Blog::STATUS_APPROVED) {
            return back()->with('error', 'Cannot comment on this blog.');
        }

        $request->validate([
            'commentText' => 'required|string|max:1000',
        ]);

        // Banned words moderation
        $bannedWords = $this->getBannedWords();
        $foundWords = $this->detectBannedWords($request->commentText, $bannedWords);

        // Determine status
        $status = empty($foundWords) ? BlogComment::STATUS_APPROVED : BlogComment::STATUS_PENDING;
        $flagReason = empty($foundWords) ? null : 'Detected banned words: ' . implode(', ', $foundWords);

        $comment = BlogComment::create([
            'blogID' => $blog->blogID,
            'userID' => Auth::id(),
            'commentText' => $request->commentText,
            'status' => $status,
            'flag_reason' => $flagReason,
        ]);

        // 🔔 NOTIFICATION: If comment is auto-approved, notify blog owner (don't notify if commenting on own blog)
        if ($status === BlogComment::STATUS_APPROVED && $blog->userID !== Auth::id()) {
            $blog->user->notify(new BlogCommentNotification($blog, $comment));
        }

        // Alert user if comment needs review
        if (!empty($foundWords)) {
            return back()->with('warning', 'Your comment has been submitted for admin review due to flagged content.');
        }

        return back()->with('success', 'Comment posted successfully!');
    }

    /**
     * Update a comment
     */
    public function update(Request $request, Blog $blog, BlogComment $comment)
    {
        // Only the comment author can update
        if ($comment->userID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'commentText' => 'required|string|max:1000',
        ]);

        // Banned words moderation
        $bannedWords = $this->getBannedWords();
        $foundWords = $this->detectBannedWords($request->commentText, $bannedWords);

        // Determine status
        $status = empty($foundWords) ? BlogComment::STATUS_APPROVED : BlogComment::STATUS_PENDING;
        $flagReason = empty($foundWords) ? null : 'Detected banned words: ' . implode(', ', $foundWords);

        $comment->update([
            'commentText' => $request->commentText,
            'status' => $status,
            'flag_reason' => $flagReason,
        ]);

        // Alert user if comment needs review
        if (!empty($foundWords)) {
            return back()->with('warning', 'Your comment has been submitted for admin review due to flagged content.');
        }

        return back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Delete a comment
     */
    public function destroy(Blog $blog, BlogComment $comment)
    {
        // Only the comment author or blog owner can delete
        if ($comment->userID !== Auth::id() && $blog->userID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
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
