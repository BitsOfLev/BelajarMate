<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StudySession;
use App\Models\User;

class StudySessionInviteRejected extends Notification
{
    use Queueable;

    protected $session;
    protected $rejecter;

    public function __construct(StudySession $session, User $rejecter)
    {
        $this->session = $session;
        $this->rejecter = $rejecter;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail']; // Email + In-app
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Study Session Invitation Declined - BelajarMate')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->rejecter->name . ' has declined your invitation to the study session.')
            ->line('**Session:** ' . $this->session->sessionName)
            ->line('You can invite other study partners or proceed with the session.')
            ->action('View Session', route('study-session.show', $this->session->sessionID))
            ->line('Thank you for using BelajarMate!');
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Invitation Declined',
            'message' => $this->rejecter->name . ' declined your invitation to "' . $this->session->sessionName . '"',
            'action_url' => route('study-session.show', $this->session->sessionID),
            'icon' => 'bx-x-circle',
            'type' => 'session_invite_rejected',
            'session_id' => $this->session->sessionID,
            'rejecter_id' => $this->rejecter->id,
            'rejecter_name' => $this->rejecter->name,
        ];
    }
}