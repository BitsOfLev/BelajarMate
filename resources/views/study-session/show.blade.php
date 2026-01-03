@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 32px;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
    } 

    .header-info {
        flex: 1;
    }

    .page-title {
        margin-bottom: 8px;
    }

    .header-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .badge {
        padding: 4px 12px;
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

    .header-actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--bm-purple);
        color: white;
    }

    .btn-primary:hover {
        background: var(--bm-purple-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        color: #374151;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    /* Card */
    .card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        padding: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-title i {
        color: var(--bm-purple);
    }

    .card-body {
        padding: 20px;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        gap: 16px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.75rem;
        color: #9ca3af;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 0.938rem;
        color: #111827;
        font-weight: 600;
    }

    .info-link {
        color: var(--bm-purple);
        text-decoration: none;
        word-break: break-all;
    }

    .info-link:hover {
        text-decoration: underline;
    }

    /* Description */
    .description-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.6;
    }

    /* Organizer */
    .organizer-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #f9fafb;
        border-radius: 8px;
    }

    .organizer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--bm-purple-lighter);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--bm-purple);
        font-size: 1.125rem;
        flex-shrink: 0;
        object-fit: cover;
    }

    .organizer-info {
        flex: 1;
    }

    .organizer-name {
        font-size: 0.938rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 2px;
    }

    .organizer-role {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Participants List */
    .participants-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .participant-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .participant-item:hover {
        background: white;
    }

    .participant-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .participant-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--bm-purple-lighter);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--bm-purple);
        font-size: 0.813rem;
        flex-shrink: 0;
        object-fit: cover;
    }

    .participant-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .participant-status {
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .participant-status.accepted {
        background: #dcfce7;
        color: #16a34a;
    }

    .participant-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .participant-status.declined {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty-participants {
        text-align: center;
        padding: 32px 16px;
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .empty-participants i {
        font-size: 2rem;
        margin-bottom: 8px;
        color: #d1d5db;
        display: block;
    }

    /* Alert Badge */
    .alert-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 8px;
    }

    .alert-today { 
        background: #fef3c7; 
        color: #78350f; 
    }

    .alert-soon { 
        background: #dbeafe; 
        color: #1e40af; 
    }

    .alert-overdue { 
        background: #fee2e2; 
        color: #991b1b; 
    }

    /* Alert Box */
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.875rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #86efac;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .alert i {
        font-size: 1.125rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Responsive */
    @media (max-width: 968px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            width: 100%;
        }

        .btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('study-session.index') }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-row">
            <div class="header-info">
                <h3 class="page-title">{{ $session->sessionName }}</h3>
                <div class="header-meta">
                    <span class="badge badge-mode {{ strtolower(str_replace('-', '-', $session->sessionMode)) }}">
                        <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                        {{ ucfirst($session->sessionMode) }}
                    </span>
                    <span class="badge badge-status {{ strtolower($session->status) }}">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>

            @if($session->userID === auth()->id())
                <div class="header-actions">
                    <a href="{{ route('study-session.edit', $session->sessionID) }}" class="btn btn-secondary">
                        <i class="bi bi-pencil"></i>
                        Edit
                    </a>
                    <form action="{{ route('study-session.destroy', $session->sessionID) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this session?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div>
            <!-- Session Details -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="bi bi-info-circle"></i>
                        Session Details
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <!-- Date & Time -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Date</div>
                                <div class="info-value">
                                    @php
                                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                                        $daysUntil = \Carbon\Carbon::now()->diffInDays($sessionDate, false);
                                        $alertBadge = '';
                                        
                                        if ($daysUntil < 0) {
                                            $alertBadge = '<span class="alert-badge alert-overdue">Past</span>';
                                        } elseif ($daysUntil == 0) {
                                            $alertBadge = '<span class="alert-badge alert-today">Today</span>';
                                        } elseif ($daysUntil > 0 && $daysUntil <= 3) {
                                            $alertBadge = '<span class="alert-badge alert-soon">' . $daysUntil . ' days away</span>';
                                        }
                                    @endphp
                                    {{ $sessionDate->format('l, F j, Y') }}
                                    {!! $alertBadge !!}
                                </div>
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Time</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                                    @if($session->endTime)
                                        - {{ \Carbon\Carbon::parse($session->endTime)->format('g:i A') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Location / Meeting Link -->
                        @if($session->sessionMode === 'online' && $session->meeting_link)
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bi bi-link-45deg"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Meeting Link</div>
                                    <div class="info-value">
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="info-link">
                                            {{ $session->meeting_link }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif($session->sessionMode === 'face-to-face' && $session->location)
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Location</div>
                                    <div class="info-value">{{ $session->location }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($session->sessionDetails)
                        <div style="margin-top: 20px;">
                            <div class="info-label" style="margin-bottom: 8px;">Description</div>
                            <div class="description-box">
                                {{ $session->sessionDetails }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Participants (for session owner) -->
            @if($session->userID === auth()->id())
                <div class="card" style="margin-top: 24px;">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="card-title">
                            <i class="bi bi-people"></i>
                            Participants
                            <span class="badge" style="background: var(--bm-purple-lighter); color: var(--bm-purple); margin-left: 8px;">
                                {{ $session->invites->where('invite_status', 'accepted')->count() }}/{{ $session->invites->count() }}
                            </span>
                        </h4>
                        <button onclick="window.location.href='{{ route('study-session.edit', $session->sessionID) }}'" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.813rem;">
                            <i class="bi bi-plus-lg"></i>
                            Invite More
                        </button>
                    </div>
                    <div class="card-body">
                        @if($session->invites->isEmpty())
                            <div class="empty-participants">
                                <i class="bi bi-person-plus"></i>
                                <div>No participants invited yet</div>
                            </div>
                        @else
                            <div class="participants-list">
                                @foreach($session->invites as $invite)
                                    <div class="participant-item">
                                        <div class="participant-user">
                                            <div class="participant-avatar">
                                                <img 
                                                    src="{{ $invite->invitedUser->userInfo->profile_image ? asset('storage/' . $invite->invitedUser->userInfo->profile_image) : asset('img/default-profile.png') }}"
                                                    class="participant-avatar"
                                                    alt="{{ $invite->invitedUser->name }}"
                                                > 
                                            </div>
                                            <div> 
                                                <div class="participant-name">{{ $invite->invitedUser->name }}</div>
                                                <div style="font-size: 0.75rem; color: #9ca3af;">
                                                    {{ $invite->invitedUser->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="participant-status {{ $invite->invite_status }}">
                                            <i class="bi bi-{{ $invite->invite_status === 'accepted' ? 'check-circle' : ($invite->invite_status === 'declined' ? 'x-circle' : 'clock') }}"></i>
                                            {{ ucfirst($invite->invite_status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Organizer -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="bi bi-person-circle"></i>
                        Organizer
                    </h4>
                </div>
                <div class="card-body">
                    <div class="organizer-card">
                        <div class="organizer-avatar">
                            <img 
                                src="{{ $session->user->userInfo->profile_image ? asset('storage/' . $session->user->userInfo->profile_image) : asset('img/default-profile.png') }}"
                                class="organizer-avatar"
                                alt="{{ $session->user->name }}"
                            > 
                        </div>
                        <div class="organizer-info">
                            <div class="organizer-name">{{ $session->user->name }}</div>
                            <div class="organizer-role">Session Organizer</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (for participants) -->
            @if($session->userID !== auth()->id())
                @php
                    $userInvite = $session->invites->where('invitedUserID', auth()->id())->first();
                @endphp
                @if($userInvite && $userInvite->invite_status === 'accepted')
                    <div class="card" style="margin-top: 24px;">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-check-circle"></i>
                                Your Status
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" style="margin: 0;">
                                <i class="bi bi-check-circle"></i>
                                <div>You've accepted this invitation</div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Session Info -->
            <div class="card" style="margin-top: 24px;">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="bi bi-info-square"></i>
                        Session Info
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Created</div>
                            <div class="info-value" style="font-size: 0.813rem; color: #6b7280;">
                                {{ \Carbon\Carbon::parse($session->created_at)->format('M j, Y') }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Last Updated</div>
                            <div class="info-value" style="font-size: 0.813rem; color: #6b7280;">
                                {{ \Carbon\Carbon::parse($session->updated_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection