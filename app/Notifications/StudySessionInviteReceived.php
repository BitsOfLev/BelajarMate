<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StudySession;
use App\Models\User;

class StudySessionInviteReceived extends Notification
{
    use Queueable;

    protected $session;
    protected $inviter;

    public function __construct(StudySession $session, User $inviter)
    {
        $this->session = $session;
        $this->inviter = $inviter;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $sessionDate = \Carbon\Carbon::parse($this->session->sessionDate);
        
        return (new MailMessage)
            ->subject('New Study Session Invitation - BelajarMate')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->inviter->name . ' has invited you to join a study session.')
            ->line('**Session Details:**')
            ->line('📚 **Title:** ' . $this->session->sessionName)
            ->line('📅 **Date:** ' . $sessionDate->format('l, F j, Y'))
            ->line('⏰ **Time:** ' . $this->session->sessionTime)
            ->line('📍 **Mode:** ' . ucfirst($this->session->sessionMode))
            ->action('View Invitation', route('study-session.show', $this->session->sessionID))
            ->line('Please respond to this invitation at your earliest convenience.')
            ->line('Thank you for using BelajarMate!');
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'New Study Session Invitation',
            'message' => $this->inviter->name . ' invited you to "' . $this->session->sessionName . '"',
            'action_url' => route('study-session.show', $this->session->sessionID),
            'icon' => 'bx-calendar-event',
            'type' => 'session_invite',
            'session_id' => $this->session->sessionID,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
            'session_date' => $this->session->sessionDate,
            'session_time' => $this->session->sessionTime,
        ];
    }
}