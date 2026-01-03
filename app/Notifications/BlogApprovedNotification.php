<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Blog;

class BlogApprovedNotification extends Notification
{
    use Queueable;

    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
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
            'type' => 'blog_approved',
            'message' => 'Your blog "' . $this->blog->blogTitle . '" has been approved and is now live!',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'icon' => 'bi-check-circle-fill',
            'color' => 'text-success',
        ];
    }
}
