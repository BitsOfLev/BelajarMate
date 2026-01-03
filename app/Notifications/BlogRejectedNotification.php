<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Blog;

class BlogRejectedNotification extends Notification
{
    use Queueable;

    protected $blog;
    protected $reason;

    public function __construct(Blog $blog, $reason = null)
    {
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
            ->subject('Your Blog Post Was Not Approved')
            ->line('Unfortunately, your blog post "' . $this->blog->blogTitle . '" was not approved.')
            ->line('Reason: ' . $this->reason)
            ->line('You can edit your blog and resubmit it for review.')
            ->action('Edit Blog', route('blog.edit', $this->blog->blogID))
            ->line('Thank you for being part of the BelajarMate community!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'blog_rejected',
            'message' => 'Your blog "' . $this->blog->blogTitle . '" was not approved.',
            'blog_id' => $this->blog->blogID,
            'blog_title' => $this->blog->blogTitle,
            'reason' => $this->reason,
            'icon' => 'bi-x-circle-fill',
            'color' => 'text-danger',
        ];
    }
}