<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\University;

class UniversityRequestApproved extends Notification
{
    use Queueable;

    protected $university;

    public function __construct(University $university)
    {
        $this->university = $university;
    }

    public function via($notifiable): array
    {
        return ['database']; // In-app only
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'University Request Approved',
            'message' => 'Your university addition request "' . $this->university->uniName . '" has been approved',
            'action_url' => null,
            'icon' => 'bx-check-circle',
            'type' => 'university_approved',
            'university_id' => $this->university->universityID,
            'university_name' => $this->university->universityName,
        ];
    }
}
