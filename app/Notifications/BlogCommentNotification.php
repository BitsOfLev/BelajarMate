<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Blog;
use App\Models\BlogComment;

class BlogCommentNotification extends Notification
{
    use Queueable;

    protected $blog;
    protected $comment;

    public function __construct(Blog $blog, BlogComment $comment)
    {
        $this->blog = $blog;
        $this->comment = $comment;
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
            'type' => 'blog_comment',
            'message' => $this->comment->user->name . ' commented on your blog "' . $this->blog->blogTitle . '"',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'comment_id' => $this->comment->commentID,
            'commenter_id' => $this->comment->userID,
            'commenter_name' => $this->comment->user->name,
            'comment_text' => \Illuminate\Support\Str::limit($this->comment->commentText, 50),
            'icon' => 'bi-chat-left-text-fill',
            'color' => 'text-primary',
        ];
    }
}
