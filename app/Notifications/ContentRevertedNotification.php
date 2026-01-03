<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Blog;
use App\Models\BlogComment;

class ContentRevertedNotification extends Notification
{
    use Queueable;

    protected $content;
    protected $contentType; // 'blog' or 'comment'
    protected $adminNotes;

    public function __construct($content, $contentType, $adminNotes)
    {
        $this->content = $content;
        $this->contentType = $contentType;
        $this->adminNotes = $adminNotes;
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
        if ($this->contentType === 'blog') {
            $title = $this->content->blogTitle;
            $actionUrl = route('blog.edit', $this->content->blogID);
        } else {
            $title = \Illuminate\Support\Str::limit($this->content->commentText, 40);
            $actionUrl = route('blog.show', $this->content->blogID);
        }
        
        return [
            'type' => 'content_reverted',
            'message' => 'Your ' . $this->contentType . ' "' . $title . '" needs revision. Please review the feedback and edit.',
            'content_type' => $this->contentType,
            'content_id' => $this->contentType === 'blog' ? $this->content->blogID : $this->content->commentID,
            'content_title' => $title,
            'admin_notes' => $this->adminNotes,
            'action_url' => $actionUrl,
            'icon' => 'bi-pencil-square',
            'color' => 'text-warning',
        ];
    }
}
