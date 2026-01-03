<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Blog;
use App\Models\User;

class BlogLikeNotification extends Notification
{
    use Queueable;

    protected $blog;
    protected $liker;

    public function __construct(Blog $blog, User $liker)
    {
        $this->blog = $blog;
        $this->liker = $liker;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'blog_like',
            'message' => $this->liker->name . ' liked your blog "' . $this->blog->blogTitle . '"',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
            'icon' => 'bi-heart-fill',
            'color' => 'text-danger',
        ];
    }
}