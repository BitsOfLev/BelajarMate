<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StudySession;
use App\Models\User;

class StudySessionCancelled extends Notification
{
    use Queueable;

    protected $session;
    protected $canceller;

    public function __construct(StudySession $session, User $canceller)
    {
        $this->session = $session;
        $this->canceller = $canceller;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail']; // Email + In-app
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $sessionDate = \Carbon\Carbon::parse($this->session->sessionDate);
        
        return (new MailMessage)
            ->subject('Study Session Cancelled - BelajarMate')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Unfortunately, a study session you were invited to has been cancelled.')
            ->line('**Session Details:**')
            ->line('📚 **Title:** ' . $this->session->sessionName)
            ->line('📅 **Date:** ' . $sessionDate->format('l, F j, Y'))
            ->line('⏰ **Time:** ' . $this->session->sessionTime)
            ->line('**Cancelled by:** ' . $this->canceller->name)
            ->line('We apologize for any inconvenience this may cause.')
            ->action('Browse Other Sessions', route('study-session.index'))
            ->line('Thank you for using BelajarMate!');
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Study Session Cancelled',
            'message' => $this->canceller->name . ' cancelled "' . $this->session->sessionName . '"',
            'action_url' => route('study-session.index'),
            'icon' => 'bx-x-circle',
            'type' => 'session_cancelled',
            'session_id' => $this->session->sessionID,
            'canceller_id' => $this->canceller->id,
            'canceller_name' => $this->canceller->name,
            'session_name' => $this->session->sessionName,
            'session_date' => $this->session->sessionDate,
        ];
    }
}
