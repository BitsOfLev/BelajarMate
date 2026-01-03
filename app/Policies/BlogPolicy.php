<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Determine if the user can view the blog
     */
    public function view(User $user, Blog $blog)
    {
        // Can view if blog is approved, or if it's their own blog
        return $blog->status === 'approved' || $blog->userID === $user->id;
    }

    /**
     * Determine if the user can update the blog
     */
    public function update(User $user, Blog $blog)
    {
        return $blog->userID === $user->id;
    }

    /**
     * Determine if the user can delete the blog
     */
    public function delete(User $user, Blog $blog)
    {
        return $blog->userID === $user->id;
    }
}