<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\BlogReport;

class ReportActionNotification extends Notification
{
    use Queueable;

    protected $report;
    protected $action;
    protected $adminNotes;

    public function __construct(BlogReport $report, $action, $adminNotes = null)
    {
        $this->report = $report;
        $this->action = $action; // 'dismissed', 'investigating', 'content_removed', 'user_warned'
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
        // Determine what was reported
        $reportedItem = '';
        $reportedType = '';
        
        if ($this->report->blogID && $this->report->blog) {
            $reportedItem = '"' . \Illuminate\Support\Str::limit($this->report->blog->blogTitle, 40) . '"';
            $reportedType = 'blog';
        } elseif ($this->report->commentID && $this->report->comment) {
            $reportedItem = 'a comment on "' . \Illuminate\Support\Str::limit($this->report->comment->blog->blogTitle, 30) . '"';
            $reportedType = 'comment';
        }

        // Build message based on action
        $messages = [
            'dismissed' => "Your report about {$reportedItem} has been reviewed and dismissed.",
            'investigating' => "Your report about {$reportedItem} is under investigation.",
            'content_removed' => "The {$reportedType} you reported has been removed. Thank you for keeping BelajarMate safe.",
            'user_warned' => "Action has been taken regarding your report about {$reportedItem}.",
        ];

        $icons = [
            'dismissed' => 'bi-x-circle',
            'investigating' => 'bi-search',
            'content_removed' => 'bi-trash-fill',
            'user_warned' => 'bi-exclamation-triangle-fill',
        ];

        $colors = [
            'dismissed' => 'text-secondary',
            'investigating' => 'text-primary',
            'content_removed' => 'text-success',
            'user_warned' => 'text-warning',
        ];

        return [
            'type' => 'report_action',
            'message' => $messages[$this->action] ?? 'Your report has been processed.',
            'report_id' => $this->report->reportID,
            'action' => $this->action,
            'admin_notes' => $this->adminNotes,
            'reported_item' => $reportedItem,
            'reported_type' => $reportedType,
            'icon' => $icons[$this->action] ?? 'bi-flag',
            'color' => $colors[$this->action] ?? 'text-muted',
        ];
    }
}
