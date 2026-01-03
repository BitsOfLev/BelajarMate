<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ConnectionRequestReceived extends Notification
{
    use Queueable;

    protected $requester;

    public function __construct(User $requester)
    {
        $this->requester = $requester;
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
            'title' => 'New Connection Request',
            'message' => $this->requester->name . ' sent you a connection request',
            'action_url' => route('connections.index'),
            'icon' => 'bx-user-plus',
            'type' => 'connection_request',
            'requester_id' => $this->requester->id,
            'requester_name' => $this->requester->name,
        ];
    }
}
