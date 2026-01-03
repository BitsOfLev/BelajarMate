@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<style>
    /* Color Variables */
    :root {
        --bm-purple: #8c52ff;
        --bm-purple-light: #f4efff;
        --bm-purple-dark: #7340d9;
        --gray-50: #fafbfc;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-900: #111827;
        --green: #22c55e;
        --orange: #f97316;
        --blue: #3b82f6;
    }

    body {
        background: var(--gray-50);
    }

    /* Greeting Header */
    .greeting-section {
        margin-bottom: 2rem;
    }

    .greeting-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .greeting-subtitle {
        color: var(--gray-600);
        font-size: 1rem;
    }

    /* Main Grid Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Card Styles */
    .card-custom {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .see-all-link {
        color: var(--bm-purple);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .see-all-link:hover {
        color: var(--bm-purple-dark);
    }

    /* Next Session Card */
    .next-session-card {
        background: linear-gradient(135deg, var(--bm-purple) 0%, #b084ff 100%);
        color: white;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .session-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.813rem;
        font-weight: 600;
        width: fit-content;
        margin-bottom: 1rem;
    }

    .session-badge.today {
        background: var(--orange);
    }

    .session-badge.tomorrow {
        background: var(--green);
    }

    .session-title-large {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .session-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        opacity: 0.95;
    }

    .session-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.938rem;
    }

    .session-detail-item i {
        font-size: 1.125rem;
    }

    /* Empty Session State */
    .empty-session-state {
        text-align: center;
        padding: 2rem 1rem;
    }

    .empty-session-state i {
        font-size: 3rem;
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .empty-session-state p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .btn-create-session {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-create-session:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    /* Upcoming Sessions Sidebar */
    .upcoming-session-item {
        padding: 14px;
        background: var(--gray-50);
        border-radius: 10px;
        border-left: 3px solid var(--bm-purple);
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .upcoming-session-item:hover {
        background: var(--bm-purple-light);
        transform: translateX(2px);
    }

    .session-date-badge {
        display: inline-block;
        background: var(--gray-200);
        color: var(--gray-700);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .session-date-badge.today {
        background: #dcfce7;
        color: #16a34a;
    }

    .session-date-badge.tomorrow {
        background: #fef3c7;
        color: #ca8a04;
    }

    .upcoming-session-title {
        font-size: 0.938rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 6px;
    }

    .upcoming-session-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.813rem;
        color: var(--gray-600);
    }

    .btn-view-session {
        width: 100%;
        padding: 8px;
        background: var(--bm-purple);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.813rem;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 10px;
        transition: all 0.2s;
    }

    .btn-view-session:hover {
        background: var(--bm-purple-dark);
        color: white;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: var(--bm-purple);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-icon.purple {
        background: var(--bm-purple-light);
        color: var(--bm-purple);
    }

    .stat-icon.orange {
        background: #ffedd5;
        color: var(--orange);
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: var(--blue);
    }

    .stat-icon.green {
        background: #dcfce7;
        color: var(--green);
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        color: var(--gray-600);
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    /* Content Grid (Planners + Notes) */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Planner Item */
    .planner-item {
        padding: 16px;
        background: var(--gray-50);
        border-radius: 10px;
        border: 1px solid var(--gray-200);
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .planner-item:hover {
        border-color: var(--bm-purple);
        background: white;
    }

    .urgency-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .urgency-badge.today {
        background: #fee2e2;
        color: #dc2626;
    }

    .urgency-badge.tomorrow {
        background: #fed7aa;
        color: #ea580c;
    }

    .urgency-badge.urgent {
        background: #fef3c7;
        color: #ca8a04;
    }

    .urgency-badge.normal {
        background: #dbeafe;
        color: #2563eb;
    }

    .planner-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 10px;
    }

    .planner-progress {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .progress-bar-container {
        flex: 1;
        height: 6px;
        background: var(--gray-200);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: var(--bm-purple);
        border-radius: 3px;
        transition: width 0.3s;
    }

    .progress-text {
        font-size: 0.813rem;
        font-weight: 600;
        color: var(--gray-600);
    }

    .planner-meta {
        font-size: 0.813rem;
        color: var(--gray-600);
        margin-bottom: 12px;
    }

    .btn-continue {
        width: 100%;
        padding: 8px;
        background: var(--bm-purple);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-continue:hover {
        background: var(--bm-purple-dark);
        color: white;
    }

    /* Note Item */
    .note-item {
        padding: 14px;
        background: var(--gray-50);
        border-radius: 10px;
        border: 1px solid var(--gray-200);
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .note-item:hover {
        border-color: var(--bm-purple);
        background: white;
    }

    .note-title {
        font-size: 0.938rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 6px;
    }

    .note-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.813rem;
        color: var(--gray-600);
        margin-bottom: 10px;
    }

    .btn-open-note {
        width: 100%;
        padding: 7px;
        background: var(--gray-100);
        color: var(--gray-700);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.813rem;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-open-note:hover {
        background: var(--gray-200);
        color: var(--gray-900);
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        color: var(--gray-300);
    }

    /* Blog Section */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .blog-grid {
            grid-template-columns: 1fr;
        }

        .greeting-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Greeting Section -->
    <div class="greeting-section">
        <h1 class="greeting-title">
            Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}, {{ Auth::user()->name }}!
        </h1>
        <p class="greeting-subtitle">
            You have {{ $activePlanners->count() }} active {{ Str::plural('planner', $activePlanners->count()) }} • {{ $upcomingSessions->count() }} upcoming {{ Str::plural('session', $upcomingSessions->count()) }}
        </p>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Left: Next Session -->
        <div class="card-custom next-session-card">
            @if($nextSession)
                <span class="session-badge {{ $nextSessionUrgency }}">
                    <i class="bi bi-{{ $nextSessionUrgency === 'today' ? 'clock-fill' : 'calendar-check' }}"></i>
                    {{ $nextSessionUrgency === 'today' ? 'TODAY' : ($nextSessionUrgency === 'tomorrow' ? 'TOMORROW' : 'UPCOMING') }}
                </span>
                
                <h2 class="session-title-large">{{ $nextSession->sessionName }}</h2>
                
                <div class="session-details">
                    <div class="session-detail-item">
                        <i class="bi bi-{{ $nextSession->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                        <span>{{ ucfirst($nextSession->sessionMode) }}{{ $nextSession->sessionMode === 'physical' && $nextSession->location ? ' • ' . $nextSession->location : '' }}</span>
                    </div>
                    <div class="session-detail-item">
                        <i class="bi bi-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($nextSession->sessionTime)->format('g:i A') }} - {{ \Carbon\Carbon::parse($nextSession->endTime)->format('g:i A') }}</span>
                    </div>
                    @if($nextSession->invites_count > 0)
                        <div class="session-detail-item">
                            <i class="bi bi-people"></i>
                            <span>{{ $nextSession->invites_count + 1 }} {{ Str::plural('participant', $nextSession->invites_count + 1) }}</span>
                        </div>
                    @else
                        <div class="session-detail-item">
                            <i class="bi bi-person"></i>
                            <span>Solo Study</span>
                        </div>
                    @endif
                </div>
            @else
                <div class="empty-session-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>No upcoming sessions scheduled</p>
                    <a href="{{ route('study-session.create') }}" class="btn-create">
                        Create Session
                    </a>
                </div>
            @endif
        </div>

        <!-- Right: Upcoming Sessions Sidebar -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h3 class="card-title">
                    <i class="bi bi-calendar-event"></i>
                    Upcoming Sessions
                </h3>
                <a href="{{ route('study-session.index') }}" class="see-all-link">See All</a>
            </div>

            @if($upcomingSessions->count() > 1)
                @foreach($upcomingSessions->skip(1)->take(3) as $session)
                    @php
                        $sessionDate = \Carbon\Carbon::parse($session->sessionDate);
                        $isToday = $sessionDate->isToday();
                        $isTomorrow = $sessionDate->isTomorrow();
                    @endphp
                    <div class="upcoming-session-item">
                        <span class="session-date-badge {{ $isToday ? 'today' : ($isTomorrow ? 'tomorrow' : '') }}">
                            {{ $isToday ? 'TODAY' : ($isTomorrow ? 'TOMORROW' : $sessionDate->format('M d')) }}
                        </span>
                        <div class="upcoming-session-title">{{ $session->sessionName }}</div>
                        <div class="upcoming-session-meta">
                            <span>
                                <i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($session->sessionTime)->format('g:i A') }}
                            </span>
                            <span>
                                <i class="bi bi-{{ $session->sessionMode === 'online' ? 'camera-video' : 'geo-alt' }}"></i>
                                {{ ucfirst($session->sessionMode) }}
                            </span>
                        </div>
                        <a href="{{ route('study-session.show', $session->sessionID) }}" class="btn-view-session">View Details</a>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>No more upcoming sessions</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-journal-text"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Active Planners</div>
                <div class="stat-value">{{ $activePlanners->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Incomplete Tasks</div>
                <div class="stat-value">{{ $incompleteTasksCount }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Upcoming Sessions</div>
                <div class="stat-value">{{ $upcomingSessions->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Study Partners</div>
                <div class="stat-value">{{ $studyPartnersCount }}</div>
            </div>
        </div>
    </div> 

    <!-- Content Grid: Planners + Notes -->
    <div class="content-grid">
        <!-- Active Planners -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h3 class="card-title">
                    <i class="bi bi-journal-check"></i>
                    Active Planners
                </h3>
                <a href="{{ route('study-planner.index') }}" class="see-all-link">View All</a>
            </div>

            @forelse($urgentPlanners as $planner)
                <div class="planner-item">
                    @if($planner->urgencyLevel)
                        <span class="urgency-badge {{ $planner->urgencyLevel }}">
                            <i class="bi bi-{{ $planner->urgencyLevel === 'today' ? 'exclamation-circle' : 'clock' }}"></i>
                            DUE {{ strtoupper($planner->urgencyLevel === 'today' ? 'TODAY' : ($planner->urgencyLevel === 'tomorrow' ? 'TOMORROW' : 'IN ' . \Carbon\Carbon::parse($planner->due_date)->diffInDays(now()->startOfDay()) . ' DAYS')) }}
                        </span>
                    @endif
                    
                    <div class="planner-title">{{ $planner->studyPlanName }}</div>
                    
                    <div class="planner-progress">
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: {{ $planner->progress }}%"></div>
                        </div>
                        <span class="progress-text">{{ $planner->progress }}%</span>
                    </div>
                    
                    @php
                        $totalTasks = $planner->tasks()->count();
                        $completedTasks = $planner->tasks()->where('taskStatus', true)->count();
                    @endphp
                    <div class="planner-meta">
                        {{ $completedTasks }}/{{ $totalTasks }} tasks completed
                        @if($planner->due_date)
                            • Due {{ \Carbon\Carbon::parse($planner->due_date)->format('M j') }}
                        @endif
                    </div>
                    
                    <a href="{{ route('study-planner.show', $planner->id) }}" class="btn-continue">Continue</a>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-journal-x"></i>
                    <p>No active planners</p>
                </div>
            @endforelse
        </div>

        <!-- Recent Notes -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h3 class="card-title">
                    <i class="bi bi-file-earmark-text"></i>
                    Recent Notes
                </h3>
                <a href="{{ route('notes.index') }}" class="see-all-link">View All</a>
            </div>

            @forelse($recentNotes as $note)
                <div class="note-item">
                    <div class="note-title">{{ $note->title }}</div>
                    <div class="note-meta">
                        <span>
                            <i class="bi bi-clock"></i>
                            {{ $note->updated_at->diffForHumans() }}
                        </span>
                        @if($note->resources()->count() > 0)
                            <span>
                                <i class="bi bi-paperclip"></i>
                                {{ $note->resources()->count() }} {{ Str::plural('resource', $note->resources()->count()) }}
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('notes.show', $note) }}" class="btn-open-note">Open</a>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-file-earmark-x"></i>
                    <p>No notes yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Latest Blogs -->
    <div>
        <div class="section-header">
            <h2 class="section-title">Latest Community Insights</h2>
            <a href="{{ route('blog.feed') }}" class="see-all-link">View All →</a>
        </div>

        @if($latestBlogs->isEmpty())
            <div class="card-custom">
                <div class="empty-state">
                    <i class="bi bi-file-text"></i>
                    <p>No blog posts yet</p>
                </div>
            </div>
        @else
            <div class="blog-grid">
                @foreach($latestBlogs as $blog)
                    <x-blog-card :blog="$blog" :showActions="false" />
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection








