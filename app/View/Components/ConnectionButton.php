<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Connection;

class ConnectionButton extends Component
{
    public $user;
    public $connection;

    public $isPending = false;
    public $isAccepted = false;
    public $isSentByMe = false;
    public $isReceivedByMe = false;

    public $buttonClass; // optional CSS classes

    public function __construct($user = null, $connection = null, $buttonClass = '')
    {
        $this->user = $user;
        $this->connection = $connection;
        $this->buttonClass = $buttonClass;

        // Fetch existing connection if $user is provided and no $connection
        if ($user && !$connection) {
            $this->connection = Connection::where(function ($q) use ($user) {
                $q->where('requesterID', Auth::id())
                  ->where('receiverID', $user->id);
            })->orWhere(function ($q) use ($user) {
                $q->where('requesterID', $user->id)
                  ->where('receiverID', Auth::id());
            })->first();
        }

        if ($this->connection) {
            $this->isPending = $this->connection->connection_status === 'pending';
            $this->isAccepted = $this->connection->connection_status === 'accepted';
            $this->isSentByMe = $this->connection->requesterID === Auth::id();
            $this->isReceivedByMe = $this->connection->receiverID === Auth::id();
        }
    }

    public function render()
    {
        return view('components.connection-button');
    }
}



