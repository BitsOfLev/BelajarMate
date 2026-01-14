@extends('layouts.main')

@section('title', 'Analytics')

@section('content')
<style>
    :root {
        --bm-purple: #8c52ff;
        --bm-purple-light: #a677ff;
        --bm-purple-lighter: #f4efff;
    }

    .analytics-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .analytics-header {
        margin-bottom: 2rem;
    }

    .analytics-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    .analytics-subtitle {
        color: #718096;
        font-size: 0.95rem;
    }

    /* Big Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        border-color: var(--bm-purple-lighter);
    }

    .stat-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-card-icon.purple {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .stat-card-icon.blue {
        background: #dbeafe;
        color: #3b82f6;
    }

    .stat-card-icon.green {
        background: #d1fae5;
        color: #10b981;
    }

    .stat-card-icon.orange {
        background: #fed7aa;
        color: #f59e0b;
    }

    .stat-card-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    .stat-card-label {
        color: #718096;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Section Card */
    .section-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: var(--bm-purple-lighter);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bm-purple);
        font-size: 1.25rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    /* Chart */
    .chart-container {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #fafbfc;
        border-radius: 12px;
    }

    /* Stats List */
    .stats-list {
        display: grid;
        gap: 0.75rem;
    }

    .stats-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .stats-item:last-child {
        border-bottom: none;
    }

    .stats-item-label {
        color: #4a5568;
        font-size: 0.875rem;
    }

    .stats-item-value {
        font-weight: 700;
        color: #1a202c;
        font-size: 1rem;
    }

    /* Top Posts */
    .top-post {
        background: #fafbfc;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-left: 4px solid var(--bm-purple);
        transition: all 0.2s;
    }

    .top-post:hover {
        background: var(--bm-purple-lighter);
        transform: translateX(4px);
    }

    .top-post-title {
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0.5rem;
        font-size: 0.925rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .top-post-engagement {
        display: flex;
        gap: 1rem;
        font-size: 0.813rem;
        color: #718096;
    }

    .top-post-engagement span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .top-post-engagement i {
        color: var(--bm-purple);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #cbd5e0;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-text {
        color: #a0aec0;
        font-size: 0.925rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .analytics-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="analytics-container">
    <!-- Header -->
    <div class="analytics-header">
        <h1 class="analytics-title">
            <i class="bi bi-graph-up-arrow me-2" style="color: var(--bm-purple);"></i>
            Your Activity Dashboard
        </h1>
        <p class="analytics-subtitle">Track your study progress and content engagement</p>
    </div>

    <!-- Big Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon purple">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-card-number">{{ $stats['total_sessions'] }}</div>
            <div class="stat-card-label">Total Sessions</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon blue">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-card-number">{{ $stats['total_partners'] }}</div>
            <div class="stat-card-label">Study Partners</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon green">
                <i class="bi bi-file-text"></i>
            </div>
            <div class="stat-card-number">{{ $stats['total_posts'] }}</div>
            <div class="stat-card-label">Blog Posts Published</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon orange">
                <i class="bi bi-chat-heart"></i>
            </div>
            <div class="stat-card-number">{{ $stats['total_engagement'] }}</div>
            <div class="stat-card-label">Total Engagement</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-grid">
        <!-- Study Activity -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h2 class="section-title">Study Sessions</h2>
            </div>

            <!-- Completion Rate Visual -->
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-weight: 700; color: #4a5568; font-size: 0.875rem;">Completion Rate</span>
                    <span style="font-weight: 700; color: var(--bm-purple); font-size: 1.25rem;">{{ $studyActivity['completion_rate'] }}%</span>
                </div>
                
                <!-- Progress Bar -->
                <div style="width: 100%; height: 20px; background: #e5e7eb; border-radius: 10px; overflow: hidden;">
                    <div style="width: {{ $studyActivity['completion_rate'] }}%; height: 100%; background: linear-gradient(90deg, var(--bm-purple) 0%, var(--bm-purple-light) 100%); transition: width 0.3s;"></div>
                </div>
                
                @php
                    $completed = $studyActivity['sessions_completed'];
                    $cancelled = $studyActivity['sessions_cancelled'];
                    $eligible = $stats['total_sessions'] - $cancelled;
                @endphp
                
                <p style="font-size: 0.813rem; color: #718096; margin-top: 0.5rem; margin-bottom: 0;">
                    {{ $completed }} completed out of {{ $eligible }} eligible sessions ({{ $cancelled }} cancelled)
                </p>
            </div>

            <!-- Session Breakdown -->
            <div class="stats-list">
                <div class="stats-item">
                    <span class="stats-item-label">
                        <i class="bi bi-check-circle-fill" style="color: #10b981; margin-right: 0.5rem;"></i>
                        Completed
                    </span>
                    <span class="stats-item-value">{{ $studyActivity['sessions_completed'] }}</span>
                </div>
                
                <div class="stats-item">
                    <span class="stats-item-label">
                        <i class="bi bi-clock-fill" style="color: #3b82f6; margin-right: 0.5rem;"></i>
                        Upcoming
                    </span>
                    <span class="stats-item-value">{{ $studyActivity['sessions_planned'] }}</span>
                </div>
                
                <div class="stats-item">
                    <span class="stats-item-label">
                        <i class="bi bi-x-circle-fill" style="color: #ef4444; margin-right: 0.5rem;"></i>
                        Cancelled
                    </span>
                    <span class="stats-item-value">{{ $studyActivity['sessions_cancelled'] }}</span>
                </div>
                
                <div class="stats-item">
                    <span class="stats-item-label">
                        <i class="bi bi-list-check" style="color: #8b5cf6; margin-right: 0.5rem;"></i>
                        Total Sessions
                    </span>
                    <span class="stats-item-value">{{ $stats['total_sessions'] }}</span>
                </div>
            </div>
        </div>

        <!-- Blog Performance -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h2 class="section-title">Blog Performance</h2>
            </div>

            <!-- Blog Stats -->
            <div class="stats-list" style="margin-bottom: 1.5rem;">
                <div class="stats-item">
                    <span class="stats-item-label">Total Posts</span>
                    <span class="stats-item-value">{{ $stats['total_posts'] }}</span>
                </div>
                <div class="stats-item">
                    <span class="stats-item-label">Total Likes</span>
                    <span class="stats-item-value">{{ $blogPerformance['total_likes'] }}</span>
                </div>
                <div class="stats-item">
                    <span class="stats-item-label">Total Comments</span>
                    <span class="stats-item-value">{{ $blogPerformance['total_comments'] }}</span>
                </div>
                <div class="stats-item">
                    <span class="stats-item-label">Avg Engagement</span>
                    <span class="stats-item-value">{{ $blogPerformance['avg_engagement'] }} per post</span>
                </div>
            </div>

            <!-- Top Posts -->
            @if($blogPerformance['top_posts']->count() > 0)
                <h6 style="font-weight: 700; color: #4a5568; margin-bottom: 1rem; font-size: 0.875rem;">
                    🔥 Top Performing Posts
                </h6>
                @foreach($blogPerformance['top_posts'] as $post)
                    <div class="top-post">
                        <div class="top-post-title">{{ $post->blogTitle }}</div>
                        <div class="top-post-engagement">
                            <span>
                                <i class="bi bi-heart-fill"></i>
                                {{ $post->likes_count }} likes
                            </span>
                            <span>
                                <i class="bi bi-chat-left-fill"></i>
                                {{ $post->comments_count }} comments
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-file-earmark-x"></i></div>
                    <p class="empty-text">No blog posts yet. Start sharing your knowledge!</p>
                </div>
            @endif
        </div>
    </div>
</div>



@endsection