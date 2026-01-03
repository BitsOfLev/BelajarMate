<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\StudySession;
use App\Models\SessionInvite;
use App\Models\Connection;
use App\Models\User;
use App\Notifications\StudySessionInviteReceived;
use App\Notifications\StudySessionCancelled; 

class StudySessionController extends Controller
{
    /**
     * Display the session scheduler dashboard with stats and upcoming sessions
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        \Log::info('=== INDEX PAGE LOADED ===', [
            'user_id' => $userId,
            'timestamp' => now()
        ]);
        
        // Get stats
        $stats = $this->getSessionStats($userId);
        
        // Get upcoming sessions (both owned and invited)
        $upcomingSessions = $this->getUpcomingSessions($userId);
        
        \Log::info('Upcoming sessions retrieved', [
            'count' => $upcomingSessions->count(),
            'sessions' => $upcomingSessions->map(function($s) {
                return [
                    'id' => $s->sessionID,
                    'name' => $s->sessionName,
                    'date' => $s->sessionDate,
                    'status' => $s->status,
                ];
            })->toArray()
        ]);
        
        // Get past sessions
        $pastSessions = $this->getPastSessions($userId);
        
        // Get cancelled sessions
        $cancelledSessions = $this->getCancelledSessions($userId);
        
        // Get pending invites for this user
        $pendingInvites = SessionInvite::where('invitedUserID', $userId)
            ->where('invite_status', 'pending')
            ->whereHas('session', function($query) {
                $query->whereNull('deleted_at'); // Only non-deleted sessions
            })
            ->with(['session.user'])
            ->get();

        return view('study-session.index', compact('stats', 'upcomingSessions', 'pastSessions', 'cancelledSessions', 'pendingInvites'));
    }

    /**
     * Get session statistics for the user
     */
    private function getSessionStats($userId)
    {
        $now = now();
        
        // Sessions user is invited to and accepted
        $invitedSessionIds = SessionInvite::where('invitedUserID', $userId)
            ->where('invite_status', 'accepted')
            ->whereHas('session', function($query) {
                $query->whereNull('deleted_at'); // Only non-deleted sessions
            })
            ->pluck('sessionID');
        
        return [
            'upcoming' => StudySession::where(function($query) use ($userId, $invitedSessionIds) {
                    $query->where('userID', $userId)
                        ->orWhereIn('sessionID', $invitedSessionIds);
                })
                ->where('sessionDate', '>=', $now->toDateString())
                ->where('status', 'planned')
                ->count(),
                
            'pending_invites' => SessionInvite::where('invitedUserID', $userId)
                ->where('invite_status', 'pending')
                ->whereHas('session', function($query) {
                    $query->whereNull('deleted_at'); // Only non-deleted sessions
                })
                ->count(),
                
            'completed' => StudySession::where('userID', $userId)
                ->where('status', 'completed')
                ->count(),
                
            'cancelled' => StudySession::where(function($query) use ($userId, $invitedSessionIds) {
                    $query->where('userID', $userId)
                        ->orWhereIn('sessionID', $invitedSessionIds);
                })
                ->where('status', 'cancelled')
                ->count(),
        ];
    }

    /**
     * Get upcoming sessions (owned or accepted invites)
     */
    private function getUpcomingSessions($userId)
    {
        $now = now();
        
        // Get sessions user owns
        $ownedSessions = StudySession::where('userID', $userId)
            ->where('sessionDate', '>=', $now->toDateString())
            ->where('status', 'planned')
            ->with(['invites' => function($query) {
                $query->where('invite_status', 'accepted');
            }, 'invites.invitedUser'])
            ->get();
        
        // Get sessions user is invited to and accepted
        $invitedSessionIds = SessionInvite::where('invitedUserID', $userId)
            ->where('invite_status', 'accepted')
            ->pluck('sessionID');
        
        $invitedSessions = StudySession::whereIn('sessionID', $invitedSessionIds)
            ->where('sessionDate', '>=', $now->toDateString())
            ->where('status', 'planned')
            ->with('user')
            ->get();
        
        // Merge and sort by date and time
        return $ownedSessions->concat($invitedSessions)
            ->sortBy([
                ['sessionDate', 'asc'],
                ['sessionTime', 'asc']
            ])
            ->values();
    }

    /**
     * Show a single session
     */
    public function show($id)
    {
        $session = StudySession::with(['invites.invitedUser', 'user'])->findOrFail($id);
        
        // Check authorization
        $this->authorizeSessionAccess($session);
        
        return view('study-session.show', compact('session'));
    }

    /**
     * Show form to create a session
     */
    public function create()
    {
        // Get user's accepted connections for inviting
        $connections = $this->getUserConnections(Auth::id());
        
        return view('study-session.create', compact('connections'));
    }

    /**
     * Store a new session with invites
     */
    public function store(Request $request)
    {
        // Log incoming request
        \Log::info('Form submitted', $request->all());

        // Validate the request
        $validated = $request->validate([
            'sessionName' => 'required|string|max:150',
            'sessionDate' => 'required|date|after_or_equal:today',
            'sessionTime' => 'required',
            'endTime' => 'nullable',
            'sessionMode' => 'required|in:online,face-to-face',
            'sessionDetails' => 'nullable|string|max:255',
            'status' => 'required|in:planned,completed,cancelled',
            'location' => 'required_if:sessionMode,face-to-face|nullable|string|max:255',
            'meeting_link' => 'required_if:sessionMode,online|nullable|url|max:255',
            'invited_users' => 'nullable|array',
            'invited_users.*' => 'exists:users,id',
        ], [
            'location.required_if' => 'Location is required for face-to-face sessions.',
            'meeting_link.required_if' => 'Meeting link is required for online sessions.',
        ]);

        // Custom validation for endTime
        if ($request->filled('endTime') && $request->filled('sessionTime')) {
            if (strtotime($request->endTime) <= strtotime($request->sessionTime)) {
                return back()
                    ->withInput()
                    ->withErrors(['endTime' => 'End time must be after start time.']);
            }
        }

        DB::beginTransaction();
        try {
            // Create the session
            $session = StudySession::create([
                'userID' => Auth::id(),
                'sessionName' => $request->sessionName,
                'sessionDate' => $request->sessionDate,
                'sessionTime' => $request->sessionTime,
                'endTime' => $request->endTime,
                'sessionMode' => $request->sessionMode,
                'sessionDetails' => $request->sessionDetails,
                'status' => $request->status,
                'location' => $request->sessionMode === 'face-to-face' ? $request->location : null,
                'meeting_link' => $request->sessionMode === 'online' ? $request->meeting_link : null,
            ]);

            \Log::info('Session created', ['id' => $session->sessionID]);

            // Send invites if any
            if ($request->filled('invited_users')) {
                $this->sendInvites($session->sessionID, $request->invited_users);
            }

            DB::commit();

            return redirect()
                ->route('study-session.show', $session->sessionID)
                ->with('success', 'Study session created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Session creation failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create session: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form to edit a session
     */
    public function edit($id)
    {
        $session = StudySession::with('invites.invitedUser')->findOrFail($id);
        
        // Only owner can edit
        if ($session->userID !== Auth::id()) {
            abort(403, 'You can only edit your own sessions.');
        }
        
        // Get user's connections for adding more invites
        $connections = $this->getUserConnections(Auth::id());
        
        return view('study-session.edit', compact('session', 'connections'));
    }

    /**
     * Update session
     */
    public function update(Request $request, $id)
    {
        $session = StudySession::findOrFail($id);
        
        // Only owner can update
        if ($session->userID !== Auth::id()) {
            abort(403, 'You can only edit your own sessions.');
        }

        $validated = $request->validate([
            'sessionName' => 'required|string|max:150',
            'sessionDate' => 'required|date',
            'sessionTime' => 'required',
            'endTime' => 'nullable',
            'sessionMode' => 'required|in:online,face-to-face',
            'sessionDetails' => 'nullable|string|max:500',
            'status' => 'required|in:planned,completed,cancelled',
            'location' => 'required_if:sessionMode,face-to-face|nullable|string|max:255',
            'meeting_link' => 'required_if:sessionMode,online|nullable|url|max:255',
            'new_invited_users' => 'nullable|array',
            'new_invited_users.*' => 'exists:users,id',
        ], [
            'location.required_if' => 'Location is required for face-to-face sessions.',
            'meeting_link.required_if' => 'Meeting link is required for online sessions.',
        ]);

        // Custom validation for endTime
        if ($request->filled('endTime') && $request->filled('sessionTime')) {
            if (strtotime($request->endTime) <= strtotime($request->sessionTime)) {
                return back()
                    ->withInput()
                    ->withErrors(['endTime' => 'End time must be after start time.']);
            }
        }

        DB::beginTransaction();
        try {
            // Check if status changed to cancelled
            $wasCancelled = $session->status !== 'cancelled' && $validated['status'] === 'cancelled';
            
            // Update session details
            $session->update([
                'sessionName' => $validated['sessionName'],
                'sessionDate' => $validated['sessionDate'],
                'sessionTime' => $validated['sessionTime'],
                'endTime' => $validated['endTime'] ?? null,
                'sessionMode' => $validated['sessionMode'],
                'sessionDetails' => $validated['sessionDetails'] ?? null,
                'status' => $validated['status'],
                'location' => $validated['sessionMode'] === 'face-to-face' ? $validated['location'] : null,
                'meeting_link' => $validated['sessionMode'] === 'online' ? $validated['meeting_link'] : null,
            ]);

            // If session was just cancelled, notify all accepted invitees
            if ($wasCancelled) {
                $acceptedInvites = SessionInvite::where('sessionID', $session->sessionID)
                    ->where('invite_status', 'accepted')
                    ->get();
                
                $canceller = Auth::user();
                
                foreach ($acceptedInvites as $invite) {
                    $invitee = User::find($invite->invitedUserID);
                    if ($invitee) {
                        $invitee->notify(new StudySessionCancelled($session, $canceller));
                    }
                }
                
                \Log::info('Session cancelled - notifications sent', [
                    'session_id' => $session->sessionID,
                    'notified_users' => $acceptedInvites->count()
                ]);
            }

            // Send new invites if any
            if ($request->filled('new_invited_users')) {
                $this->sendInvites($session->sessionID, $request->new_invited_users);
            }

            DB::commit();

            $message = 'Study session updated successfully!';
            if ($wasCancelled) {
                $message .= ' All participants have been notified.';
            } elseif ($request->filled('new_invited_users')) {
                $count = count($request->new_invited_users);
                $message .= " {$count} new invitation(s) sent.";
            }

            return redirect()
                ->route('study-session.show', $session->sessionID)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to update study session', [
                'error' => $e->getMessage(),
                'sessionID' => $id
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update session. Please try again.');
        }
    }

    /**
     * Soft delete a session
     */
    public function destroy($id)
    {
        $session = StudySession::findOrFail($id);
        
        // Only owner can delete
        if ($session->userID !== Auth::id()) {
            abort(403, 'You can only delete your own sessions.');
        }
        
        try {
            $session->delete();

            return redirect()
                ->route('study-session.index')
                ->with('success', 'Study session deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to delete study session', [
                'error' => $e->getMessage(),
                'sessionID' => $id
            ]);

            return back()->with('error', 'Failed to delete session. Please try again.');
        }
    }

    /**
     * Invite users to an existing session (for adding more invites after creation)
     */
    public function invite(Request $request, $id)
    {
        $session = StudySession::findOrFail($id);

        // Only session owner can invite
        if ($session->userID !== Auth::id()) {
            abort(403, 'Only the session owner can send invites.');
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            // Validate users are connections
            $this->validateConnections(Auth::id(), $request->user_ids);

            $this->sendInvites($session->sessionID, $request->user_ids);

            return redirect()
                ->route('study-session.show', $session->sessionID)
                ->with('success', 'Invitations sent successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to send invites', [
                'error' => $e->getMessage(),
                'sessionID' => $id
            ]);

            return back()->with('error', 'Failed to send invitations. Please try again.');
        }
    }

    /**
     * View all invites for a session
     */
    public function invites($id)
    {
        $session = StudySession::with('invites.invitedUser')->findOrFail($id);

        // Check authorization
        $this->authorizeSessionAccess($session);

        return view('study-session.invites', compact('session'));
    }

    // ==================== Helper Methods ====================

    /**
     * Check if user can access this session
     */
    private function authorizeSessionAccess($session)
    {
        $userId = Auth::id();
        
        $isOwner = $session->userID === $userId;
        $isInvited = $session->invites->contains('invitedUserID', $userId);
        
        if (!$isOwner && !$isInvited) {
            abort(403, 'You do not have access to this session.');
        }
    }

    /**
     * Get user's accepted connections
     */
    private function getUserConnections($userId)
    {
        $connections = Connection::where('connection_status', Connection::STATUS_ACCEPTED)
            ->where(function($query) use ($userId) {
                $query->where('requesterID', $userId)
                      ->orWhere('receiverID', $userId);
            })
            ->with(['requester', 'receiver'])
            ->get();

        // Extract the connected users
        return $connections->map(function($connection) use ($userId) {
            return $connection->requesterID === $userId 
                ? $connection->receiver 
                : $connection->requester;
        })->unique('id');
    }

    /**
     * Validate that all user IDs are accepted connections
     */
    private function validateConnections($userId, $userIds)
    {
        $connections = $this->getUserConnections($userId);
        $connectionIds = $connections->pluck('id')->toArray();
        
        foreach ($userIds as $invitedUserId) {
            if (!in_array($invitedUserId, $connectionIds)) {
                throw new \Exception('You can only invite users you are connected with.');
            }
        }
    }


    /**
     * Send invites to users
     */
    private function sendInvites($sessionId, $userIds)
    {
        $session = StudySession::find($sessionId);
        $inviter = Auth::user();
        
        foreach ($userIds as $userId) {
            // Check if invite already exists
            $existing = SessionInvite::where('sessionID', $sessionId)
                                    ->where('invitedUserID', $userId)
                                    ->first();
            
            if (!$existing) {
                // Create the invite
                SessionInvite::create([
                    'sessionID' => $sessionId,
                    'invitedUserID' => $userId,
                    'invite_status' => 'pending',
                    'invited_at' => now(),
                ]);
                
                // Send notification to invitee
                $invitee = User::find($userId);
                $invitee->notify(new StudySessionInviteReceived($session, $inviter));
                
                \Log::info('Notification sent', [
                    'session' => $session->sessionID,
                    'inviter' => $inviter->id,
                    'invitee' => $invitee->id
                ]);
            }
        }
    }


    /**
     * Get past sessions (owned or accepted invites)
     */
    private function getPastSessions($userId)
    {
        $now = now();
        
        // Get past sessions user owns (completed or past planned dates)
        $ownedSessions = StudySession::where('userID', $userId)
            ->where(function($query) use ($now) {
                $query->where('status', 'completed')
                    ->orWhere(function($q) use ($now) {
                        $q->where('sessionDate', '<', $now->toDateString())
                            ->where('status', 'planned');
                    });
            })
            ->with(['invites' => function($query) {
                $query->where('invite_status', 'accepted');
            }, 'invites.invitedUser'])
            ->get();
        
        // Get past sessions user was invited to and accepted
        $invitedSessionIds = SessionInvite::where('invitedUserID', $userId)
            ->where('invite_status', 'accepted')
            ->pluck('sessionID');
        
        $invitedSessions = StudySession::whereIn('sessionID', $invitedSessionIds)
            ->where(function($query) use ($now) {
                $query->where('status', 'completed')
                    ->orWhere(function($q) use ($now) {
                        $q->where('sessionDate', '<', $now->toDateString())
                            ->where('status', 'planned');
                    });
            })
            ->with('user')
            ->get();
        
        // Merge and sort by date (most recent first)
        return $ownedSessions->concat($invitedSessions)
            ->sortByDesc([
                ['sessionDate', 'desc'],
                ['sessionTime', 'desc']
            ])
            ->values();
    }

    /**
     * Get cancelled sessions (owned or accepted invites that were cancelled)
     */
    private function getCancelledSessions($userId)
    {
        // Get cancelled sessions user owns
        $ownedSessions = StudySession::where('userID', $userId)
            ->where('status', 'cancelled')
            ->with(['invites' => function($query) {
                $query->where('invite_status', 'accepted');
            }, 'invites.invitedUser'])
            ->get();
        
        // Get cancelled sessions user was invited to and accepted
        $invitedSessionIds = SessionInvite::where('invitedUserID', $userId)
            ->where('invite_status', 'accepted')
            ->pluck('sessionID');
        
        $invitedSessions = StudySession::whereIn('sessionID', $invitedSessionIds)
            ->where('status', 'cancelled')
            ->with('user')
            ->get();
        
        // Merge and sort by date (most recent first)
        return $ownedSessions->concat($invitedSessions)
            ->sortByDesc([
                ['sessionDate', 'desc'],
                ['sessionTime', 'desc']
            ])
            ->values();
    }
}