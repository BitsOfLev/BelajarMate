<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\University;

class UniversityRequestRejected extends Notification
{
    use Queueable;

    protected $university;
    protected $reason;

    public function __construct(University $university, $reason = null)
    {
        $this->university = $university;
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail']; // Email + In-app
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('University Addition Request Rejected - BelajarMate')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Unfortunately, your university addition request has been rejected by the administrator.')
            ->line('**University Name:** ' . $this->university->uniName);
        
        if ($this->reason) {
            $mail->line('**Reason:** ' . $this->reason);
        }
        
        return $mail
            ->line('You can submit a new request after reviewing the guidelines.')
            ->action('View Universities', route('home'))
            ->line('Thank you for contributing to BelajarMate!');
    }

    public function toArray($notifiable): array
    {
        $message = 'Your university addition request "' . $this->university->uniName . '" has been rejected';
        
        return [
            'title' => 'University Request Rejected',
            'message' => $message,
            'action_url' => route('home'),
            'icon' => 'bx-x-circle',
            'type' => 'university_rejected',
            'university_id' => $this->university->uniID,
            'university_name' => $this->university->uniName,
            // 'reason' => $this->reason,
        ];
    }
}
