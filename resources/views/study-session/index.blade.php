@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    .page-header {
        margin-bottom: 32px;
    }

    /* Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .stat-icon.purple { background: #f4efff; color: var(--bm-purple); }
    .stat-icon.blue { background: #dbeafe; color: #2563eb; }
    .stat-icon.green { background: #dcfce7; color: #16a34a; }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }

    /* Section Tabs */
    .section-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 0;
    }

    .tab-btn {
        padding: 12px 24px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.938rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: -2px;
    }

    .tab-btn.active {
        color: var(--bm-purple);
        border-bottom-color: var(--bm-purple);
    }

    .tab-btn:hover:not(.active) {
        color: #374151;
    }

    .tab-badge {
        display: inline-block;
        background: #f3f4f6;
        color: #6b7280;
        padding: 2px 8px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: 6px;
    }

    .tab-btn.active .tab-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    /* Tab Content */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Session List */
    .session-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* Session Card */
    .session-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .session-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    .session-card.owner {
        border-left: 4px solid var(--bm-purple);
    }

    .session-card.invited {
        border-left: 4px solid #3b82f6;
    }

    /* Card Header */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .session-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
        flex: 1;
        margin-right: 12px;
    }

    .card-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #f9fafb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.938rem;
        position: relative;
    }

    .btn-action:hover {
        background: #f3f4f6;
    }

    .btn-action.view:hover {
        color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }

    .btn-action.edit:hover {
        color: #3b82f6;
        background: #eff6ff;
    }

    .btn-action.delete:hover {
        color: #dc2626;
        background: #fef2f2;
    }

    .btn-action::after {
        content: attr(data-tip);
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 3px 9px;
        border-radius: 5px;
        font-size: 0.688rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 10;
    }

    .btn-action:hover::after {
        opacity: 1;
    }

    /* Badges */
    .badge-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .badge {
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-mode {
        background: #f3f4f6;
        color: #4b5563;
    }

    .badge-mode.online {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-mode.face-to-face {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status {
        background: #dcfce7;
        color: #16a34a;
    }

    .badge-status.cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-status.completed {
        background: #e0e7ff;
        color: #4338ca;
    }

    .badge-role {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        font-weight: 700;
    }

    .badge-role.invited {
        background: #eff6ff;
        color: #2563eb;
    }

    /* Session Info Grid */
    .session-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.813rem;
        color: #6b7280;
    }

    .info-item i {
        font-size: 1rem;
        color: #9ca3af;
    }

    .info-value {
        font-weight: 600;
        color: #374151;
    }

    /* Participants Section */
    .participants-section {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
    }

    .participants-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .participants-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .participant-badge {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .participant-badge i {
        font-size: 0.625rem;
    }

    .participant-badge.accepted {
        background: #dcfce7;
        border-color: #86efac;
        color: #16a34a;
    }

    .participant-badge.pending {
        background: #fef3c7;
        border-color: #fde047;
        color: #92400e;
    }

    /* Invite Card */
    .invite-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        border-left: 4px solid #f59e0b;
    }

    .invite-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    .invite-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .invite-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .invite-from {
        font-size: 0.813rem;
        color: #6b7280;
    }

    .invite-from strong {
        color: #374151;
        font-weight: 600;
    }

    .invite-actions {
        display: flex;
        gap: 8px;
        margin-top: 16px;
    }

    .btn-invite {
        flex: 1;
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-invite.accept {
        background: #22c55e;
        color: white;
    }

    .btn-invite.accept:hover {
        background: #16a34a;
    }

    .btn-invite.decline {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-invite.decline:hover {
        background: #e5e7eb;
        color: #374151;
    }

    /* Alert Badge */
    .alert-badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 50px;
        font-size: 0.625rem;
        font-weight: 600;
        margin-left: 5px;
    }

    .alert-today { background: #fef3c7; color: #78350f; }
    .alert-soon { background: #dbeafe; color: #1e40af; }

    /* Empty State */
    .empty-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
    }

    .empty-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .empty-icon-circle i {
        font-size: 2rem;
        color: #d1d5db;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #9ca3af;
        font-size: 0.938rem;
        margin-bottom: 24px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .stats-bar {
            grid-template-columns: 1fr;
        }

        .section-tabs {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tab-btn {
            white-space: nowrap;
        }

        .session-info {
            grid-template-columns: 1fr;
        }

        .invite-actions {
            flex-direction: column;
        }
    }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">Study Sessions</h3>
        <p class="page-subtitle">Schedule and manage collaborative study sessions</p>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Upcoming Sessions</div>
                    <div class="stat-value">{{ $stats['upcoming'] }}</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Pending Invites</div>
                    <div class="stat-value">{{ $stats['pending_invites'] }}</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Completed Sessions</div>
                    <div class="stat-value">{{ $stats['completed'] }}</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Cancelled Sessions</div>
                    <div class="stat-value">{{ $stats['cancelled'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tabs -->
    <div class="section-tabs">
        <button class="tab-btn active" onclick="switchTab('upcoming')">
            Upcoming Sessions
            <span class="tab-badge">{{ $upcomingSessions->count() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('invites')">
            Pending Invites
            <span class="tab-badge">{{ $pendingInvites->count() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('past')">
            Past Sessions
            <span class="tab-badge">{{ $pastSessions->count() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('cancelled')">
            Cancelled
            <span class="tab-badge">{{ $cancelledSessions->count() }}</span>
        </button>
    </div>

    <!-- Upcoming Sessions Tab -->
    <div id="upcoming-tab" class="tab-content active">
        <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
            <a href="{{ route('study-session.create') }}" class="btn-create">
                <i class="bi bi-plus-lg"></i>
                <span>New Session</span>
            </a>
        </div>

        @if($upcomingSessions->isEmpty())
            <div class="empty-container">
                <div class="empty-icon-circle">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <h3 class="empty-title">No upcoming sessions</h3>
                <p class="empty-text">Create your first study session to start collaborating with your study partners</p>
                <a href="{{ route('study-session.create') }}" class="btn-create">
                    <i class="bi bi-plus-lg"></i>
                    <span>Create Your First Session</span>
                </a>
            </div>
        @else
            <div class="session-list">
                @foreach($upcomingSessions as $session)
                    @php
                        $isOwner = $session->userID === auth()->id();
                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                        $daysUntil = \Carbon\Carbon::now()->diffInDays($sessionDate, false);
                        $alertBadge = '';
                        
                        if ($daysUntil == 0) {
                            $alertBadge = '<span class="alert-badge alert-today">Today</span>';
                        } elseif ($daysUntil > 0 && $daysUntil <= 3) {
                            $alertBadge = '<span class="alert-badge alert-soon">' . $daysUntil . 'd away</span>';
                        }
                        
                        $acceptedInvites = $session->invites->where('invite_status', 'accepted');
                    @endphp

                    <div class="session-card {{ $isOwner ? 'owner' : 'invited' }}">
                        <!-- Header -->
                        <div class="card-header">
                            <h3 class="session-title">{{ $session->sessionName }}</h3>
                            @if($isOwner)
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('study-session.edit', $session->sessionID) }}" class="btn-action edit" data-tip="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('study-session.destroy', $session->sessionID) }}" method="POST" 
                                          onsubmit="return confirm('Delete this session?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" data-tip="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Badges -->
                        <div class="badge-row">
                            <span class="badge badge-mode {{ strtolower(str_replace('-', '-', $session->sessionMode)) }}">
                                <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                                {{ ucfirst($session->sessionMode) }}
                            </span>
                            <span class="badge badge-status {{ strtolower($session->status) }}">
                                {{ ucfirst($session->status) }}
                            </span>
                            <span class="badge badge-role {{ $isOwner ? '' : 'invited' }}">
                                {{ $isOwner ? 'Organizer' : 'Participant' }}
                            </span>
                        </div>

                        <!-- Session Info -->
                        <div class="session-info">
                            <div class="info-item">
                                <i class="bi bi-calendar3"></i>
                                <span class="info-value">
                                    {{ $sessionDate->format('M d, Y') }}
                                    {!! $alertBadge !!}
                                </span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock"></i>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                                    @if($session->endTime)
                                        - {{ \Carbon\Carbon::parse($session->endTime)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                            @if($session->sessionMode === 'online' && $session->meeting_link)
                                <div class="info-item">
                                    <i class="bi bi-link-45deg"></i>
                                    <a href="{{ $session->meeting_link }}" target="_blank" class="info-value" style="color: var(--bm-purple);">
                                        Join Meeting
                                    </a>
                                </div>
                            @elseif($session->sessionMode === 'face-to-face' && $session->location)
                                <div class="info-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="info-value">{{ $session->location }}</span>
                                </div>
                            @endif
                        </div>

                        @if($session->sessionDetails)
                            <div style="margin-top: 12px; font-size: 0.875rem; color: #6b7280;">
                                {{ $session->sessionDetails }}
                            </div>
                        @endif

                        <!-- Participants -->
                        @if($isOwner && $session->invites->isNotEmpty())
                            <div class="participants-section">
                                <div class="participants-label">Participants ({{ $acceptedInvites->count() }}/{{ $session->invites->count() }})</div>
                                <div class="participants-list">
                                    @foreach($session->invites as $invite)
                                        <span class="participant-badge {{ $invite->invite_status }}">
                                            <i class="bi bi-{{ $invite->invite_status === 'accepted' ? 'check-circle-fill' : 'clock' }}"></i>
                                            {{ $invite->invitedUser->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!$isOwner)
                            <div class="participants-section">
                                <div class="participants-label">Organized by</div>
                                <div class="participants-list">
                                    <span class="participant-badge">
                                        <i class="bi bi-person-circle"></i>
                                        {{ $session->user->name }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Pending Invites Tab -->
    <div id="invites-tab" class="tab-content">
        @if($pendingInvites->isEmpty())
            <div class="empty-container">
                <div class="empty-icon-circle">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 class="empty-title">No pending invites</h3>
                <p class="empty-text">You're all caught up! Check back later for new session invitations</p>
            </div>
        @else
            <div class="session-list">
                @foreach($pendingInvites as $invite)
                    @php
                        $session = $invite->session;
                        
                        if (!$session) continue;

                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                        $daysUntil = \Carbon\Carbon::now()->diffInDays($sessionDate, false);
                        $alertBadge = '';
                        
                        if ($daysUntil == 0) {
                            $alertBadge = '<span class="alert-badge alert-today">Today</span>';
                        } elseif ($daysUntil > 0 && $daysUntil <= 3) {
                            $alertBadge = '<span class="alert-badge alert-soon">' . $daysUntil . 'd away</span>';
                        }
                    @endphp

                    <div class="invite-card">
                        <div class="invite-header">
                            <div>
                                <h3 class="invite-title">{{ $session->sessionName }}</h3>
                                <p class="invite-from">
                                    Invited by <strong>{{ $session->user->name }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="badge-row">
                            <span class="badge badge-mode {{ strtolower(str_replace('-', '-', $session->sessionMode)) }}">
                                <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                                {{ ucfirst($session->sessionMode) }}
                            </span>
                        </div>

                        <!-- Session Info -->
                        <div class="session-info">
                            <div class="info-item">
                                <i class="bi bi-calendar3"></i>
                                <span class="info-value">
                                    {{ $sessionDate->format('M d, Y') }}
                                    {!! $alertBadge !!}
                                </span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock"></i>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                                    @if($session->endTime)
                                        - {{ \Carbon\Carbon::parse($session->endTime)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($session->sessionDetails)
                            <div style="margin-top: 12px; font-size: 0.875rem; color: #6b7280;">
                                {{ $session->sessionDetails }}
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="invite-actions">
                            <form action="{{ route('invites.respond', $invite->inviteID) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="invite_status" value="accepted">
                                <button type="submit" class="btn-invite accept" style="width: 100%;">
                                    <i class="bi bi-check-lg"></i>
                                    Accept
                                </button>
                            </form>
                            <form action="{{ route('invites.respond', $invite->inviteID) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="invite_status" value="declined">
                                <button type="submit" class="btn-invite decline" style="width: 100%;">
                                    <i class="bi bi-x-lg"></i>
                                    Decline
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Past Sessions Tab -->
    <div id="past-tab" class="tab-content">
        @if($pastSessions->isEmpty())
            <div class="empty-container">
                <div class="empty-icon-circle">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3 class="empty-title">No past sessions</h3>
                <p class="empty-text">Your completed and past sessions will appear here</p>
            </div>
        @else
            <div class="session-list">
                @foreach($pastSessions as $session)
                    @php
                        $isOwner = $session->userID === auth()->id();
                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                        $acceptedInvites = $session->invites->where('invite_status', 'accepted');
                    @endphp

                    <div class="session-card {{ $isOwner ? 'owner' : 'invited' }}" style="opacity: 0.85;">
                        <!-- Header -->
                        <div class="card-header">
                            <h3 class="session-title">{{ $session->sessionName }}</h3>
                            @if($isOwner)
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('study-session.edit', $session->sessionID) }}" class="btn-action edit" data-tip="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('study-session.destroy', $session->sessionID) }}" method="POST" 
                                        onsubmit="return confirm('Delete this session?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" data-tip="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Badges -->
                        <div class="badge-row">
                            <span class="badge badge-mode {{ strtolower(str_replace('-', '-', $session->sessionMode)) }}">
                                <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                                {{ ucfirst($session->sessionMode) }}
                            </span>
                            <span class="badge badge-status {{ strtolower($session->status) }}">
                                {{ ucfirst($session->status) }}
                            </span>
                            <span class="badge badge-role {{ $isOwner ? '' : 'invited' }}">
                                {{ $isOwner ? 'Organizer' : 'Participant' }}
                            </span>
                            <span class="alert-badge alert-overdue">Past</span>
                        </div>

                        <!-- Session Info -->
                        <div class="session-info">
                            <div class="info-item">
                                <i class="bi bi-calendar3"></i>
                                <span class="info-value">{{ $sessionDate->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock"></i>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                                    @if($session->endTime)
                                        - {{ \Carbon\Carbon::parse($session->endTime)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                            @if($session->sessionMode === 'online' && $session->meeting_link)
                                <div class="info-item">
                                    <i class="bi bi-link-45deg"></i>
                                    <a href="{{ $session->meeting_link }}" target="_blank" class="info-value" style="color: var(--bm-purple);">
                                        Meeting Link
                                    </a>
                                </div>
                            @elseif($session->sessionMode === 'face-to-face' && $session->location)
                                <div class="info-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="info-value">{{ $session->location }}</span>
                                </div>
                            @endif
                        </div>

                        @if($session->sessionDetails)
                            <div style="margin-top: 12px; font-size: 0.875rem; color: #6b7280;">
                                {{ $session->sessionDetails }}
                            </div>
                        @endif

                        <!-- Participants -->
                        @if($isOwner && $session->invites->isNotEmpty())
                            <div class="participants-section">
                                <div class="participants-label">Participants ({{ $acceptedInvites->count() }}/{{ $session->invites->count() }})</div>
                                <div class="participants-list">
                                    @foreach($session->invites as $invite)
                                        <span class="participant-badge {{ $invite->invite_status }}">
                                            <i class="bi bi-{{ $invite->invite_status === 'accepted' ? 'check-circle-fill' : 'clock' }}"></i>
                                            {{ $invite->invitedUser->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!$isOwner)
                            <div class="participants-section">
                                <div class="participants-label">Organized by</div>
                                <div class="participants-list">
                                    <span class="participant-badge">
                                        <i class="bi bi-person-circle"></i>
                                        {{ $session->user->name }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Cancelled Sessions Tab -->
    <div id="cancelled-tab" class="tab-content">
        @if($cancelledSessions->isEmpty())
            <div class="empty-container">
                <div class="empty-icon-circle">
                    <i class="bi bi-x-circle"></i>
                </div>
                <h3 class="empty-title">No cancelled sessions</h3>
                <p class="empty-text">Sessions that have been cancelled will appear here</p>
            </div>
        @else
            <div class="session-list">
                @foreach($cancelledSessions as $session)
                    @php
                        $isOwner = $session->userID === auth()->id();
                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                        $acceptedInvites = $session->invites->where('invite_status', 'accepted');
                    @endphp

                    <div class="session-card {{ $isOwner ? 'owner' : 'invited' }}" style="opacity: 0.75; border-left-color: #dc2626;">
                        <!-- Header -->
                        <div class="card-header">
                            <h3 class="session-title">{{ $session->sessionName }}</h3>
                            @if($isOwner)
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('study-session.destroy', $session->sessionID) }}" method="POST" 
                                        onsubmit="return confirm('Delete this session permanently?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" data-tip="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card-actions">
                                    <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-action view" data-tip="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Badges -->
                        <div class="badge-row">
                            <span class="badge badge-mode {{ strtolower(str_replace('-', '-', $session->sessionMode)) }}">
                                <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                                {{ ucfirst($session->sessionMode) }}
                            </span>
                            <span class="badge badge-status cancelled">
                                <i class="bi bi-x-circle"></i>
                                Cancelled
                            </span>
                            <span class="badge badge-role {{ $isOwner ? '' : 'invited' }}">
                                {{ $isOwner ? 'Organizer' : 'Participant' }}
                            </span>
                        </div>

                        <!-- Session Info -->
                        <div class="session-info">
                            <div class="info-item">
                                <i class="bi bi-calendar3"></i>
                                <span class="info-value">{{ $sessionDate->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock"></i>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                                    @if($session->endTime)
                                        - {{ \Carbon\Carbon::parse($session->endTime)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                            @if($session->sessionMode === 'face-to-face' && $session->location)
                                <div class="info-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="info-value">{{ $session->location }}</span>
                                </div>
                            @endif
                        </div>

                        @if($session->sessionDetails)
                            <div style="margin-top: 12px; font-size: 0.875rem; color: #6b7280;">
                                {{ $session->sessionDetails }}
                            </div>
                        @endif

                        <!-- Participants -->
                        @if($isOwner && $session->invites->isNotEmpty())
                            <div class="participants-section">
                                <div class="participants-label">Participants ({{ $acceptedInvites->count() }}/{{ $session->invites->count() }})</div>
                                <div class="participants-list">
                                    @foreach($session->invites as $invite)
                                        <span class="participant-badge {{ $invite->invite_status }}">
                                            <i class="bi bi-{{ $invite->invite_status === 'accepted' ? 'check-circle-fill' : 'clock' }}"></i>
                                            {{ $invite->invitedUser->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!$isOwner)
                            <div class="participants-section">
                                <div class="participants-label">Organized by</div>
                                <div class="participants-list">
                                    <span class="participant-badge">
                                        <i class="bi bi-person-circle"></i>
                                        {{ $session->user->name }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


<script>
    function switchTab(tab) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        // Add active class to selected tab
        if (tab === 'upcoming') {
            document.querySelector('.tab-btn:nth-child(1)').classList.add('active');
            document.getElementById('upcoming-tab').classList.add('active');
        } else if (tab === 'invites') {
            document.querySelector('.tab-btn:nth-child(2)').classList.add('active');
            document.getElementById('invites-tab').classList.add('active');
        } else if (tab === 'past') {
            document.querySelector('.tab-btn:nth-child(3)').classList.add('active');
            document.getElementById('past-tab').classList.add('active');
        } else if (tab === 'cancelled') {
            document.querySelector('.tab-btn:nth-child(4)').classList.add('active');
            document.getElementById('cancelled-tab').classList.add('active');
        }
    }

    // Show success/error messages
    @if(session('success'))
        // You can add your toast notification here
        console.log('{{ session('success') }}');
    @endif

    @if(session('error'))
        // You can add your toast notification here
        console.error('{{ session('error') }}');
    @endif
</script>

@endsection


