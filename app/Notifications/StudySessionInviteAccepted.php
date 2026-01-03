<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StudySession;
use App\Models\User;

class StudySessionInviteAccepted extends Notification
{
    use Queueable;

    protected $session;
    protected $accepter;

    public function __construct(StudySession $session, User $accepter)
    {
        $this->session = $session;
        $this->accepter = $accepter;
    }

    public function via($notifiable): array
    {
        return ['database']; // In-app only
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Invitation Accepted',
            'message' => $this->accepter->name . ' accepted your invitation to "' . $this->session->sessionName . '"',
            'action_url' => route('study-session.show', $this->session->sessionID),
            'icon' => 'bx-check-circle',
            'type' => 'session_invite_accepted',
            'session_id' => $this->session->sessionID,
            'accepter_id' => $this->accepter->id,
            'accepter_name' => $this->accepter->name,
        ];
    }
}