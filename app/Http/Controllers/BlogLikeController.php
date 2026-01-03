<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BlogLikeNotification;

class BlogLikeController extends Controller
{
    /**
     * Toggle like on a blog post
     */
    public function toggle(Blog $blog)
    {
        if ($blog->status !== Blog::STATUS_APPROVED) {
            return back()->with('error', 'Cannot like a blog that is not approved.');
        }

        $userId = Auth::id();

        // Check for existing like (including soft-deleted)
        $like = BlogLike::withTrashed()
            ->where('blogID', $blog->blogID)
            ->where('userID', $userId)
            ->first();

        if ($like) {
            if ($like->trashed()) {
                // If it was soft-deleted, restore it (re-like)
                $like->restore();
                
                // Send like notification 
                if ($blog->userID !== $userId) {
                    $blog->user->notify(new BlogLikeNotification($blog, Auth::user()));
                }
            } else {
                // If it exists and not deleted, soft delete it (unlike)
                $like->delete();
            }
        } else {
            // Create new like
            try {
                BlogLike::create([
                    'blogID' => $blog->blogID,
                    'userID' => $userId,
                ]);
                
                // Send like notification 
                if ($blog->userID !== $userId) {
                    $blog->user->notify(new BlogLikeNotification($blog, Auth::user()));
                }
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                // If duplicate, just continue
            }
        }

        return back();
    }
}
