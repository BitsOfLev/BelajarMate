<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SessionInvite;
use App\Notifications\StudySessionInviteAccepted;
use App\Notifications\StudySessionInviteRejected;

class SessionInviteController extends Controller
{
    /**
     * Respond to a session invite (accept/decline)
     */
    public function respond(Request $request, $inviteId)
    {
        $invite = SessionInvite::with('sessionWithTrashed.user')->findOrFail($inviteId);

        // Check if the session was soft-deleted
        if (!$invite->sessionWithTrashed || $invite->sessionWithTrashed->trashed()) {
            return back()->with('error', 'This study session has been cancelled or deleted.');
        }

        // Rest of your code stays the same...
        $session = $invite->sessionWithTrashed;
        
        // Only invited user can respond
        if ($invite->invitedUserID !== Auth::id()) {
            abort(403, 'You are not authorized to respond to this invite.');
        }

        // Can't respond to already responded invites
        if ($invite->invite_status !== 'pending') {
            return back()->with('error', 'This invite has already been responded to.');
        }

        $request->validate([
            'invite_status' => 'required|in:accepted,declined',
        ]);

        $invite->update([
            'invite_status' => $request->invite_status,
            'responded_at' => now(),
        ]);

        // Send notification to session owner
        $sessionOwner = $session->user;
        $responder = Auth::user();
        
        if ($request->invite_status === 'accepted') {
            $sessionOwner->notify(new StudySessionInviteAccepted($session, $responder));
            $message = 'Invite accepted successfully!';
        } else {
            $sessionOwner->notify(new StudySessionInviteRejected($session, $responder));
            $message = 'Invite declined.';
        }

        return redirect()->route('study-session.index')->with('success', $message);
    }

    /**
     * Cancel an invite (by session owner)
     */
    public function cancel($inviteId)
    {
        $invite = SessionInvite::with('session')->findOrFail($inviteId);

        // Only session owner can cancel invites
        if ($invite->session->userID !== Auth::id()) {
            abort(403, 'Only the session owner can cancel invites.');
        }

        $sessionId = $invite->session->sessionID;
        $invite->delete();

        return redirect()->route('study-session.edit', $sessionId)->with('success', 'Participant removed successfully.');
    }
}