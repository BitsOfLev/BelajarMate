@extends('layouts.main')

@section('title', 'Study Partner')

@section('content')
<style>
    /* BelajarMate Purple */
    :root {
        --bm-purple: #8c52ff;
        --bm-purple-light: #a677ff;
        --bm-purple-lighter: #f4efff;
    }

    /* Layout */
    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Left Sidebar */
    .profile-sidebar {
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        text-align: center;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 20px;
        border: 4px solid var(--bm-purple-lighter);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 8px;
    }

    .profile-course {
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .profile-location {
        color: #718096;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-bottom: 20px;
    }

    /* Main Content */
    .profile-main {
        min-height: 400px;
    }

    .about-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }

    .about-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 15px;
    }

    .about-text {
        color: #4a5568;
        line-height: 1.7;
        font-size: 0.95rem;
    }

    /* Tabs */
    .profile-tabs {
        background: white;
        border-radius: 12px;
        padding: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        display: flex;
        gap: 5px;
    }

    .profile-tabs .nav-link {
        border: none;
        color: #718096;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.2s;
        background: transparent;
        font-size: 0.9rem;
    }

    .profile-tabs .nav-link:hover {
        color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }

    .profile-tabs .nav-link.active {
        color: white;
        background: var(--bm-purple);
    }

    /* Info Section */
    .info-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-icon-box {
        width: 40px;
        height: 40px;
        background: var(--bm-purple-lighter);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bm-purple);
        font-size: 1.2rem;
    }

    .section-header h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    /* Info List */
    .info-list {
        display: grid;
        gap: 15px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #718096;
        font-size: 0.9rem;
    }

    .info-value {
        color: #1a202c;
        font-weight: 500;
        font-size: 0.9rem;
        text-align: right;
    }

    /* Preferences Grid */
    .pref-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .pref-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border-left: 4px solid var(--bm-purple);
    }

    .pref-label {
        font-size: 0.75rem;
        color: #718096;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
    }

    .pref-value {
        font-size: 1.05rem;
        color: #1a202c;
        font-weight: 600;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
    }

    .stat-box {
        background: linear-gradient(135deg, var(--bm-purple) 0%, var(--bm-purple-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 30px 20px;
        text-align: center;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.95;
        font-weight: 500;
    }

    /* Empty State */
    .empty-box {
        text-align: center;
        padding: 60px 20px;
        color: #cbd5e0;
    }

    .empty-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
    }

    .empty-text {
        font-size: 1rem;
        color: #a0aec0;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .profile-sidebar {
            position: relative;
            top: 0;
        }

        .sidebar-card {
            padding: 25px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
        }
    }

    @media (max-width: 576px) {
        .profile-tabs {
            flex-direction: column;
        }

        .profile-tabs .nav-link {
            width: 100%;
        }

        .pref-grid {
            grid-template-columns: 1fr;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .info-value {
            text-align: left;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <div class="profile-layout">
        <!-- Left Sidebar -->
        <aside class="profile-sidebar">
            <div class="sidebar-card">
                <img 
                    src="{{ $user->userInfo->profile_image ? asset('storage/' . $user->userInfo->profile_image) : asset('img/default-profile.png') }}"
                    class="profile-avatar"
                    alt="{{ $user->name }}"
                > 
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-course">{{ $user->userInfo->course->name ?? 'Course not specified' }}</p>
                <p class="profile-location">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ $user->userInfo->university->name ?? 'University not specified' }}</span>
                </p>

                <x-connection-button :user="$user" buttonClass="w-80" />

            </div>
        </aside>

        <!-- Main Content -->
        <main class="profile-main">
            <!-- About Me -->
            <div class="about-card">
                <h2 class="about-title">About Me</h2>
                <p class="about-text">
                    {{ $user->userInfo->aboutMe ?? 'This user hasn\'t added an about me section yet. Connect with them to learn more!' }}
                </p>
            </div>

            <!-- Tabs -->
            <ul class="nav profile-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">
                        Academic Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" type="button" role="tab">
                        Preferences
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                        Activity
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="profileTabsContent">
                @php
                    $ui = $user->userInfo;
                    $preferredTime = is_array($ui->preferred_time) ? implode(', ', $ui->preferred_time) : $ui->preferred_time;
                    $preferredMode = is_array($ui->preferred_mode) ? implode(', ', $ui->preferred_mode) : $ui->preferred_mode;
                @endphp

                <!-- Academic Info Tab -->
                <div class="tab-pane fade show active" id="academic" role="tabpanel">
                    <div class="info-section">
                        <div class="section-header">
                            <div class="section-icon-box">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <h3>Academic Information</h3>
                        </div>
                        
                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label">Course / Major</span>
                                <span class="info-value">{{ $ui->course->name ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Education Level</span>
                                <span class="info-value">{{ $ui->educationLevel->name ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">Academic Year</span>
                                <span class="info-value">{{ $ui->academicYear ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="info-item">
                                <span class="info-label">University</span>
                                <span class="info-value">{{ $ui->university->name ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferences Tab -->
                <div class="tab-pane fade" id="preferences" role="tabpanel">
                    <div class="info-section">
                        <div class="section-header">
                            <div class="section-icon-box">
                                <i class="bi bi-sliders"></i>
                            </div>
                            <h3>Study Preferences</h3>
                        </div>
                        
                        <div class="pref-grid">
                            <div class="pref-item">
                                <div class="pref-label">Study Time</div>
                                <div class="pref-value">{{ $preferredTime ?? 'Not specified' }}</div>
                            </div>
                            
                            <div class="pref-item">
                                <div class="pref-label">Study Mode</div>
                                <div class="pref-value">{{ $preferredMode ?? 'Not specified' }}</div>
                            </div>
                            
                            <div class="pref-item">
                                <div class="pref-label">MBTI Type</div>
                                <div class="pref-value">{{ $ui->mbti->mbti ?? 'Not specified' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Tab -->
                <div class="tab-pane fade" id="activity" role="tabpanel">
                    <div class="info-section">
                        <div class="section-header">
                            <div class="section-icon-box">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h3>Activity Statistics</h3>
                        </div>
                        
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Study Sessions</div>
                            </div>
                            
                            <div class="stat-box">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Blog Posts Liked</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection

