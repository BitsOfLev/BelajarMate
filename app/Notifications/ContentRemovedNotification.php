<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContentRemovedNotification extends Notification
{
    use Queueable;

    protected $contentType; // 'blog' or 'comment'
    protected $contentTitle;
    protected $reason;

    public function __construct($contentType, $contentTitle, $reason)
    {
        $this->contentType = $contentType;
        $this->contentTitle = $contentTitle;
        $this->reason = $reason;
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
        $itemType = $this->contentType === 'blog' ? 'Blog Post' : 'Comment';
        
        return (new MailMessage)
            ->subject('Your ' . $itemType . ' Was Removed')
            ->line('Your ' . strtolower($itemType) . ' "' . $this->contentTitle . '" has been removed by our moderation team.')
            ->line('Reason: ' . $this->reason)
            ->line('This action was taken because the content violated our community guidelines.')
            ->line('If you believe this was done in error, please contact our support team.')
            ->line('Thank you for your understanding!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $itemType = $this->contentType === 'blog' ? 'blog post' : 'comment';
        
        return [
            'type' => 'content_removed',
            'message' => 'Your ' . $itemType . ' "' . $this->contentTitle . '" was removed by admin.',
            'content_type' => $this->contentType,
            'content_title' => $this->contentTitle,
            'reason' => $this->reason,
            'icon' => 'bi-trash-fill',
            'color' => 'text-danger',
        ];
    }
}
