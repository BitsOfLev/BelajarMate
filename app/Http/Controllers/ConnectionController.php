<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Notifications\ConnectionRequestReceived;
use App\Notifications\ConnectionRequestAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    /**
     * Display connections page (redirect to study partner)
     */
    public function index()
    {
        return redirect()->route('study-partner.index');
    }

    // Send a connection request
    public function sendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $receiver = (int) $request->input('receiver_id');

        if ($user->id === $receiver) {
            return redirect()->route('study-partner.index')->with('error', 'You cannot connect to yourself.');
        }

        // Check if a connection exists (in any direction)
        $existing = Connection::where(function($q) use ($user, $receiver) {
            $q->where('requesterID', $user->id)->where('receiverID', $receiver);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('requesterID', $receiver)->where('receiverID', $user->id);
        })->first();

        if ($existing) {
            // If pending or accepted, don't allow
            if (in_array($existing->connection_status, [Connection::STATUS_PENDING, Connection::STATUS_ACCEPTED])) {
                return redirect()->route('study-partner.index')->with('error', 'A request already exists or you are already connected.');
            }

            // If rejected, allow re-sending by updating the existing record
            $existing->update([
                'requesterID' => $user->id,
                'receiverID' => $receiver,
                'connection_status' => Connection::STATUS_PENDING,
            ]);

            // Send notification to receiver
            $receiverUser = User::find($receiver);
            $receiverUser->notify(new ConnectionRequestReceived($user));

            return redirect()->route('study-partner.index')->with('success', 'Connection request re-sent.');
        }

        // Create new connection request
        Connection::create([
            'requesterID' => $user->id,
            'receiverID' => $receiver,
            'connection_status' => Connection::STATUS_PENDING,
        ]);

        // Send notification to receiver
        $receiverUser = User::find($receiver);
        $receiverUser->notify(new ConnectionRequestReceived($user));

        return redirect()->route('study-partner.index')->with('success', 'Connection request sent.');
    }

    // Accept a request (receiver only)
    public function acceptRequest($id)
    {
        $user = Auth::user();
        $conn = Connection::findOrFail($id);

        // Only receiver can accept
        if ($conn->receiverID !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only pending requests can be accepted
        if ($conn->connection_status !== Connection::STATUS_PENDING) {
            return redirect()->route('study-partner.index')->with('error', 'This request cannot be accepted.');
        }

        $conn->update(['connection_status' => Connection::STATUS_ACCEPTED]);

        // Send notification to requester
        $requester = User::find($conn->requesterID);
        $requester->notify(new ConnectionRequestAccepted($user));

        return redirect()->route('study-partner.index')->with('success', 'Connection accepted.');
    }

    // Reject a request (receiver only)
    public function rejectRequest($id)
    {
        $user = Auth::user();
        $conn = Connection::findOrFail($id);

        // Only receiver can reject
        if ($conn->receiverID !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the connection instead of marking as rejected
        // This allows the requester to send a new request later
        $conn->delete();

        return redirect()->route('study-partner.index')->with('success', 'Connection request rejected.');
    }

    // Remove connection (either side)
    public function remove($id)
    {
        $user = Auth::user();
        $conn = Connection::findOrFail($id);

        // Check if user is part of this connection
        if (!in_array($user->id, [$conn->requesterID, $conn->receiverID])) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the connection
        $conn->delete();

        return redirect()->route('study-partner.index')->with('success', 'Connection removed.');
    }
}
