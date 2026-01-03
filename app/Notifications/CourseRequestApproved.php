<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Course;

class CourseRequestApproved extends Notification
{
    use Queueable;

    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function via($notifiable): array
    {
        return ['database']; // In-app only
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Course Request Approved',
            'message' => 'Your course addition request "' . $this->course->courseName . '" has been approved',
            'action_url' => route('profile.index'), // or wherever courses are shown
            'icon' => 'bx-check-circle',
            'type' => 'course_approved',
            'course_id' => $this->course->courseID,
            'course_name' => $this->course->courseName,
        ];
    }
}
