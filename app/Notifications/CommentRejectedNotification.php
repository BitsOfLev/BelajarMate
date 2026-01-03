<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\BlogComment;
use App\Models\Blog;

class CommentRejectedNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $blog;
    protected $reason;

    public function __construct(BlogComment $comment, Blog $blog, $reason = null)
    {
        $this->comment = $comment;
        $this->blog = $blog;
        $this->reason = $reason ?? 'No reason provided';
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Comment Was Not Approved')
            ->line('Unfortunately, your comment on "' . $this->blog->blogTitle . '" was not approved.')
            ->line('Reason: ' . $this->reason)
            ->line('Please review our community guidelines before commenting again.')
            ->action('View Blog', route('blog.show', $this->blog->blogID))
            ->line('Thank you for understanding!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'comment_rejected',
            'message' => 'Your comment on "' . $this->blog->blogTitle . '" was not approved.',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'comment_id' => $this->comment->commentID,
            'comment_text' => \Illuminate\Support\Str::limit($this->comment->commentText, 50),
            'reason' => $this->reason,
            'icon' => 'bi-x-circle-fill',
            'color' => 'text-danger',
        ];
    }
}
