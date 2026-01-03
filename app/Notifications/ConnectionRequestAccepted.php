<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ConnectionRequestAccepted extends Notification
{
    use Queueable;

    protected $accepter;

    public function __construct(User $accepter)
    {
        $this->accepter = $accepter;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database']; // In-app only
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Connection Request Accepted',
            'message' => $this->accepter->name . ' accepted your connection request',
            'action_url' => route('connections.index'),
            'icon' => 'bx-user-check',
            'type' => 'connection_accepted',
            'accepter_id' => $this->accepter->id,
            'accepter_name' => $this->accepter->name,
        ];
    }
}
