<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Course;

class CourseRequestRejected extends Notification
{
    use Queueable;

    protected $course;
    protected $reason;

    public function __construct(Course $course, $reason = null)
    {
        $this->course = $course;
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail']; // Email + In-app
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Course Addition Request Rejected - BelajarMate')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your recent request to add a course has been reviewed and, unfortunately, could not be approved by the administrator at this time.
                    Next Steps: If you would like to appeal this decision, please reply to this email or contact us directly at admin@belajarmate.com. 
                    Please include your request ID or course title for faster processing. ')
            ->line('**Course Name:** ' . $this->course->courseName);
        
        if ($this->reason) {
            $mail->line('**Reason:** ' . $this->reason);
        }
        
        return $mail
            ->line('You can submit a new request after reviewing the guidelines.')
            ->action('View Courses', route('home'))
            ->line('Thank you for contributing to BelajarMate!');
    }

    public function toArray($notifiable): array
    {
        $message = 'Your course addition request "' . $this->course->courseName . '" has been rejected';
        
        if ($this->reason) {
            $message .= '. Reason: ' . $this->reason;
        }
        
        return [
            'title' => 'Course Request Rejected',
            'message' => $message,
            'action_url' => route('home'),
            'icon' => 'bx-x-circle',
            'type' => 'course_rejected',
            'course_id' => $this->course->courseID,
            'course_name' => $this->course->courseName,
            'reason' => $this->reason,
        ];
    }
}
