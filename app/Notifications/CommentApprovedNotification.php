<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\BlogComment;
use App\Models\Blog;

class CommentApprovedNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $blog;

    public function __construct(BlogComment $comment, Blog $blog)
    {
        $this->comment = $comment;
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
            'type' => 'comment_approved',
            'message' => 'Your comment on "' . $this->blog->blogTitle . '" has been approved.',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'comment_id' => $this->comment->commentID,
            'comment_text' => \Illuminate\Support\Str::limit($this->comment->commentText, 50),
            'icon' => 'bi-check-circle-fill',
            'color' => 'text-success',
        ];
    }
}
