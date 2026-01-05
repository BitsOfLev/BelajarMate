<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BlogApprovedNotification;
use App\Notifications\BlogRejectedNotification;
use App\Notifications\CommentApprovedNotification;
use App\Notifications\CommentRejectedNotification;
use App\Notifications\BlogCommentNotification;
use App\Notifications\ReportActionNotification;
use App\Notifications\ContentRemovedNotification;
use App\Notifications\ContentRevertedNotification;

class BlogModerationController extends Controller
{
    /**
     * Admin Blog Moderation Dashboard
     */
    public function index()
    {
        $stats = [
            'pending_blogs' => Blog::where('status', Blog::STATUS_PENDING)->count(),
            'pending_comments' => BlogComment::where('status', BlogComment::STATUS_PENDING)
                ->whereHas('blog') // Only comments with existing blogs
                ->count(),
            'pending_reports' => BlogReport::where('status', BlogReport::STATUS_PENDING)
                ->where(function($q) {
                    // Only reports where content still exists
                    $q->whereHas('blog')  // Blog reports with existing blog
                    ->orWhereHas('comment', function($commentQuery) {
                        $commentQuery->whereHas('blog'); // Comment reports with existing blog
                    });
                })
                ->count(),
            'total_blogs' => Blog::count(),
            'total_comments' => BlogComment::whereHas('blog')->count(), // Only comments with existing blogs
        ];

        return view('admin.blog-moderation.index', compact('stats'));
    }

    /**
     * View all pending blogs
     */
    public function pendingBlogs(Request $request)
    {
        $query = Blog::with(['user', 'category'])
            ->where('status', Blog::STATUS_PENDING)
            ->latest('posted_at');

        // Filter by flag type
        if ($request->filter === 'banned_words') {
            $query->where('flag_reason', 'like', '%banned words%');
        } elseif ($request->filter === 'images') {
            $query->where('flag_reason', 'like', '%image%');
        }

        $blogs = $query->paginate(15);

        return view('admin.blog-moderation.pending-blogs', compact('blogs'));
    }

    /**
     * View all pending comments
     */
    public function pendingComments()
    {
        $comments = BlogComment::with(['user', 'blog'])
            ->where('status', BlogComment::STATUS_PENDING)
            ->whereHas('blog') 
            ->latest('created_at')
            ->paginate(20);

        return view('admin.blog-moderation.pending-comments', compact('comments'));
    }

    /**
     * View all reports
     */
    public function reports(Request $request)
    {
        $query = BlogReport::with(['user', 'blog', 'comment'])
            ->where(function($q) {
                // Only show reports where content still exists
                $q->whereHas('blog')  // Blog reports with existing blog
                ->orWhereHas('comment', function($commentQuery) {
                    $commentQuery->whereHas('blog'); // Comment reports with existing blog
                });
            })
            ->latest('created_at');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->type === 'blog') {
            $query->whereNotNull('blogID')->whereHas('blog');
        } elseif ($request->type === 'comment') {
            $query->whereNotNull('commentID')->whereHas('comment.blog');
        }

        $reports = $query->paginate(20);

        return view('admin.blog-moderation.reports', compact('reports'));
    }

    /**
     * Show single blog for review
     */
    public function showBlog(Blog $blog)
    {
        $blog->load(['user', 'category', 'comments']);
        return view('admin.blog-moderation.show-blog', compact('blog'));
    }

    /**
     * Show single comment for review
     */
    public function showComment(BlogComment $comment)
    {
        $comment->load(['user', 'blog']);
        
        // Check if blog still exists
        if (!$comment->blog) {
            // Auto-delete the orphaned comment
            $comment->delete();
            
            return redirect()->route('admin.blog-moderation.pending-comments')
                ->with('error', 'The blog associated with this comment has been deleted. Comment removed.');
        }
        
        return view('admin.blog-moderation.show-comment', compact('comment'));
    }

    /**
     * Show single report
     */
    public function showReport(BlogReport $report)
    {
        $report->load(['user', 'blog.user', 'comment.user', 'comment.blog']);
        
        // Check if reported blog exists 
        if ($report->blogID && !$report->blog) {
            return redirect()->route('admin.blog-moderation.reports')
                ->with('error', 'The reported blog has been deleted.');
        }
        
        // Check if reported comment's blog exists 
        if ($report->commentID && $report->comment && !$report->comment->blog) {
            // Auto-delete the orphaned comment
            $report->comment->delete();
            
            return redirect()->route('admin.blog-moderation.reports')
                ->with('error', 'The blog associated with this comment has been deleted. Comment removed.');
        }
        
        return view('admin.blog-moderation.show-report', compact('report'));
    }

    /**
     * Approve a blog
     */
    public function approveBlog(Blog $blog)
    {
        $blog->update([
            'status' => Blog::STATUS_APPROVED,
            'flag_reason' => null,
        ]);

        // Notify blog author
        $blog->user->notify(new BlogApprovedNotification($blog));

        return back()->with('success', 'Blog approved successfully!');
    }

    /**
     * Reject a blog
     */
    public function rejectBlog(Request $request, Blog $blog)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $blog->update([
            'status' => Blog::STATUS_REJECTED,
            'flag_reason' => 'Rejected: ' . $request->rejection_reason,
        ]);

        // Notify blog author (in-app + email)
        $blog->user->notify(new BlogRejectedNotification($blog, $request->rejection_reason));

        return back()->with('success', 'Blog rejected and user notified.');
    }

    /**
     * Delete a blog (soft delete)
     */
    public function deleteBlog(Request $request, Blog $blog)
    {
        $request->validate([
            'deletion_reason' => 'required|string|max:1000',
        ]);

        // Store deletion reason before deleting
        $blog->update([
            'flag_reason' => 'Deleted by admin: ' . $request->deletion_reason,
        ]);

        // Notify author (in-app + email)
        $blog->user->notify(new ContentRemovedNotification('blog', $blog->blogTitle, $request->deletion_reason));

        $blog->delete();

        return redirect()->route('admin.blog-moderation.pending-blogs')
            ->with('success', 'Blog deleted and author notified.');
    }

    /**
     * Approve a comment
     */
    public function approveComment(BlogComment $comment)
    {
        $comment->update([
            'status' => BlogComment::STATUS_APPROVED,
            'flag_reason' => null,
        ]);

        // Notify comment author
        $comment->user->notify(new CommentApprovedNotification($comment, $comment->blog));
        
        // Notify blog owner about new comment (if not their own)
        if ($comment->blog->userID !== $comment->userID) {
            $comment->blog->user->notify(new BlogCommentNotification($comment->blog, $comment));
        }

        return back()->with('success', 'Comment approved successfully!');
    }

    /**
     * Reject a comment
     */
    public function rejectComment(Request $request, BlogComment $comment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $comment->update([
            'status' => BlogComment::STATUS_REJECTED,
            'flag_reason' => 'Rejected: ' . $request->rejection_reason,
        ]);

        //  Notify comment author (in-app + email)
        $comment->user->notify(new CommentRejectedNotification($comment, $comment->blog, $request->rejection_reason));

        return back()->with('success', 'Comment rejected and user notified.');
    }

    /**
     * Delete a comment (soft delete)
     */
    public function deleteComment(Request $request, BlogComment $comment)
    {
        $request->validate([
            'deletion_reason' => 'required|string|max:1000',
        ]);

        $commentText = $comment->commentText;
        $blogTitle = $comment->blog->blogTitle;
        $commentAuthor = $comment->user;

        // Store deletion reason before deleting
        $comment->update([
            'flag_reason' => 'Deleted by admin: ' . $request->deletion_reason,
        ]);

        // Notify author (in-app + email)
        $commentAuthor->notify(new ContentRemovedNotification(
            'comment', 
            \Illuminate\Support\Str::limit($commentText, 50) . ' on "' . $blogTitle . '"', 
            $request->deletion_reason
        ));

        $comment->delete();

        return redirect()->route('admin.blog-moderation.pending-comments')
            ->with('success', 'Comment deleted and author notified.');
    }

    /**
     * Dismiss a report
     */
    public function dismissReport(Request $request, BlogReport $report)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $report->update([
            'status' => BlogReport::STATUS_DISMISSED,
            'admin_notes' => $request->admin_notes,
        ]);

        // Notify reporter with admin notes
        $report->user->notify(new ReportActionNotification($report, 'dismissed', $request->admin_notes));

        return back()->with('success', 'Report dismissed and reporter notified.');
    }

    /**
     * Mark report as under investigation
     */
    public function investigateReport(Request $request, BlogReport $report)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => 'investigating', // You'll need to add this status to BlogReport model
            'admin_notes' => $request->admin_notes ?? 'Under investigation',
        ]);

        // Notify reporter
        $report->user->notify(new ReportActionNotification($report, 'investigating', $request->admin_notes));

        return back()->with('success', 'Report marked as under investigation.');
    }

    /**
     * Revert content to pending for user to edit
     */
    public function revertReport(Request $request, BlogReport $report)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        if ($report->blogID) {
            // Revert blog to pending
            $report->blog->update([
                'status' => Blog::STATUS_PENDING,
                'flag_reason' => 'Requires revision: ' . $request->admin_notes,
            ]);

            // Notify blog author to edit
            $report->blog->user->notify(new ContentRevertedNotification($report->blog, 'blog', $request->admin_notes));
            
            $report->update([
                'status' => BlogReport::STATUS_REVIEWED,
                'admin_notes' => 'Content reverted for editing: ' . $request->admin_notes,
            ]);

            // Notify reporter
            $report->user->notify(new ReportActionNotification($report, 'investigating', 'The content has been sent back for revision.'));

            return back()->with('success', 'Blog reverted to pending. Author can edit and resubmit.');
        } elseif ($report->commentID) {
            // Revert comment to pending
            $report->comment->update([
                'status' => BlogComment::STATUS_PENDING,
                'flag_reason' => 'Requires revision: ' . $request->admin_notes,
            ]);

            //Notify comment author
            $report->comment->user->notify(new ContentRevertedNotification($report->comment, 'comment', $request->admin_notes));

            $report->update([
                'status' => BlogReport::STATUS_REVIEWED,
                'admin_notes' => 'Content reverted for editing: ' . $request->admin_notes,
            ]);

            //  Notify reporter
            $report->user->notify(new ReportActionNotification($report, 'investigating', 'The content has been sent back for revision.'));

            return back()->with('success', 'Comment reverted to pending. Author can edit.');
        }

        return back()->with('error', 'Invalid report type.');
    }

    /**
     * Take action on report (delete reported content)
     */
    public function actionReport(Request $request, BlogReport $report)
    {
        $request->validate([
            'action' => 'required|in:delete_content,warn_user',
            'admin_notes' => 'required|string|max:1000',
        ]);

        if ($request->action === 'delete_content') {
            if ($report->blogID) {
                $blog = $report->blog;
                $blogAuthor = $blog->user;
                $blogTitle = $blog->blogTitle;
                
                // Delete blog
                $blog->update([
                    'flag_reason' => 'Deleted by admin: ' . $request->admin_notes,
                ]);
                
                // Notify blog author (in-app + email)
                $blogAuthor->notify(new ContentRemovedNotification('blog', $blogTitle, $request->admin_notes));
                
                $blog->delete();
            } elseif ($report->commentID) {
                $comment = $report->comment;
                $commentAuthor = $comment->user;
                $commentText = $comment->commentText;
                $blogTitle = $comment->blog->blogTitle;
                
                // Delete comment
                $comment->update([
                    'flag_reason' => 'Deleted by admin: ' . $request->admin_notes,
                ]);
                
                // Notify comment author (in-app + email)
                $commentAuthor->notify(new ContentRemovedNotification(
                    'comment',
                    \Illuminate\Support\Str::limit($commentText, 50) . ' on "' . $blogTitle . '"',
                    $request->admin_notes
                ));
                
                $comment->delete();
            }

            $report->update([
                'status' => BlogReport::STATUS_REVIEWED,
                'admin_notes' => 'Content deleted: ' . $request->admin_notes,
            ]);

            // Notify reporter
            $report->user->notify(new ReportActionNotification($report, 'content_removed', $request->admin_notes));

            return back()->with('success', 'Content deleted. Both reporter and author notified.');
        }

        // Warn user 
        $report->update([
            'status' => BlogReport::STATUS_REVIEWED,
            'admin_notes' => 'Warning issued: ' . $request->admin_notes,
        ]);

        // Notify reporter
        $report->user->notify(new ReportActionNotification($report, 'user_warned', $request->admin_notes));

        return back()->with('success', 'User warned. Reporter notified.');
    }
}