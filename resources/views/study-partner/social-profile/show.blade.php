@extends('layouts.main')

@section('title', $user->name . ' - Social Profile')

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

    /* Quick Stats */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .quick-stat {
        text-align: center;
    }

    .quick-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--bm-purple);
        display: block;
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: #718096;
        margin-top: 5px;
    }

    /* Top Partners Section */
    .top-partners-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .top-partners-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .top-partners-title i {
        color: var(--bm-purple);
    }

    .partner-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 10px;
        transition: all 0.2s;
        text-decoration: none;
        color: inherit;
    }

    .partner-item:hover {
        background: var(--bm-purple-lighter);
        transform: translateX(4px);
    }

    .partner-item-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--bm-purple-lighter);
    }

    .partner-item-info {
        flex: 1;
        min-width: 0;
    }

    .partner-item-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .partner-item-score {
        font-size: 0.75rem;
        color: var(--bm-purple);
        font-weight: 600;
    }

    .partner-item-mbti {
        font-size: 0.75rem;
        color: #718096;
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
        flex-wrap: wrap;
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
        margin-bottom: 25px;
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

    /* Schedule Section */
    .schedule-section {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 2px solid #f0f0f0;
    }

    .schedule-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .schedule-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a202c;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .schedule-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 15px;
    }

    .schedule-upload-form {
        margin-top: 15px;
    }

    .schedule-upload-area {
        border: 2px dashed var(--bm-purple-lighter);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: #fafbfc;
        transition: all 0.2s;
    }

    .schedule-upload-area:hover {
        border-color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }

    .schedule-upload-icon {
        font-size: 3rem;
        color: var(--bm-purple);
        margin-bottom: 10px;
    }

    .schedule-upload-text {
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .btn-upload-schedule {
        background: var(--bm-purple);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-upload-schedule:hover {
        background: var(--bm-purple-light);
        transform: translateY(-2px);
    }

    .btn-delete-schedule {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-delete-schedule:hover {
        background: #b91c1c;
    }

    /* Session Card */
    .session-card {
        background: linear-gradient(135deg, var(--bm-purple-lighter) 0%, #fff 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        border: 2px solid var(--bm-purple-lighter);
    }

    .session-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .session-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 0.9rem;
        color: #4a5568;
    }

    .session-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .session-info-item i {
        color: var(--bm-purple);
        width: 20px;
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

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

                {{-- Conditional Button: Edit Profile vs Connect --}}
                @if($isOwnProfile)
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>
                @else
                    <x-connection-button :user="$user" buttonClass="w-100" />
                @endif

                {{-- Quick Stats --}}
                <div class="quick-stats">
                    <div class="quick-stat">
                        <span class="quick-stat-number">{{ $activities['total_sessions'] }}</span>
                        <small class="quick-stat-label">Sessions</small>
                    </div>
                    <div class="quick-stat">
                        <span class="quick-stat-number">{{ $activities['total_partners'] }}</span>
                        <small class="quick-stat-label">Partners</small>
                    </div>
                    <div class="quick-stat">
                        <span class="quick-stat-number">{{ $activities['total_blog_posts'] }}</span>
                        <small class="quick-stat-label">Posts</small>
                    </div>
                </div>

                {{-- Top Study Partners --}}
                @if($activities['total_partners'] > 0)
                    <div class="top-partners-section">
                        <div class="top-partners-title">
                            <i class="bi bi-people-fill"></i>
                            Top Study Partners
                        </div>
                        
                        @forelse($activities['top_partners'] as $partner)
                            <a href="{{ route('study-partner.social-profile.show', $partner->id) }}" class="partner-item">
                                <img 
                                    src="{{ $partner->userInfo->profile_image ? asset('storage/' . $partner->userInfo->profile_image) : asset('img/default-profile.png') }}"
                                    class="partner-item-avatar"
                                    alt="{{ $partner->name }}"
                                >
                                <div class="partner-item-info">
                                    <div class="partner-item-name">{{ $partner->name }}</div>
                                    @if($partner->compatibility_score)
                                        <div class="partner-item-score">{{ $partner->compatibility_score }}% Compatible</div>
                                    @else
                                        <div class="partner-item-mbti">{{ $partner->userInfo->mbti->mbti ?? 'MBTI not set' }}</div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small text-center mb-0">Complete your profile to see compatibility scores</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </aside>

        <!-- Main Content -->
        <main class="profile-main">
            <!-- About Me -->
            <div class="about-card">
                <h2 class="about-title">About Me</h2>
                <p class="about-text">
                    {{ $user->userInfo->aboutMe ?? ($isOwnProfile ? 'You haven\'t added an about me section yet. Edit your profile to add one!' : 'This user hasn\'t added an about me section yet.') }}
                </p>
            </div>

            <!-- Tabs -->
            <ul class="nav profile-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">
                        <i class="bi bi-mortarboard"></i> Academic
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" type="button" role="tab">
                        <i class="bi bi-sliders"></i> Preferences
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                        <i class="bi bi-graph-up"></i> Activity
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog" type="button" role="tab">
                        <i class="bi bi-file-text"></i> Blog Posts
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

                {{-- Academic Info Tab --}}
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

                {{-- Preferences Tab --}}
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

                        {{-- Schedule Section --}}
                        <div class="schedule-section">
                            <div class="schedule-header">
                                <div class="schedule-title">
                                    <i class="bi bi-calendar-week"></i>
                                    Study Schedule
                                </div>
                                
                                @if($isOwnProfile && $ui->study_schedule)
                                    <form action="{{ route('profile.schedule.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your schedule?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-schedule">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            @if($ui->study_schedule)
                                {{-- Display Existing Schedule --}}
                                <img src="{{ asset('storage/' . $ui->study_schedule) }}" class="schedule-image" alt="Study Schedule">
                                
                                @if($isOwnProfile)
                                    <p class="text-muted small text-center">Want to update? Upload a new schedule below to replace this one.</p>
                                @endif
                            @else
                                {{-- No Schedule Uploaded --}}
                                @if(!$isOwnProfile)
                                    <div class="empty-box">
                                        <div class="empty-icon"><i class="bi bi-calendar3"></i></div>
                                        <p class="empty-text">No schedule uploaded yet</p>
                                    </div>
                                @endif
                            @endif

                            {{-- Upload Form (Only for Own Profile) --}}
                            @if($isOwnProfile)
                                <div class="schedule-upload-form">
                                    <form action="{{ route('profile.schedule.upload') }}" method="POST" enctype="multipart/form-data" id="scheduleUploadForm">
                                        @csrf
                                        <div class="schedule-upload-area">
                                            <div class="schedule-upload-icon">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                            <p class="schedule-upload-text">
                                                {{ $ui->study_schedule ? 'Upload a new schedule to replace the current one' : 'Upload your study schedule' }}
                                            </p>
                                            <input type="file" name="study_schedule" id="study_schedule" accept="image/*,.pdf" style="display: none;" onchange="document.getElementById('scheduleUploadForm').submit();">
                                            <label for="study_schedule" class="btn-upload-schedule">
                                                <i class="bi bi-upload me-2"></i>Choose File
                                            </label>
                                            <p class="text-muted small mt-2 mb-0">Accepted formats: JPG, PNG, PDF (Max: 2MB)</p>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Activity Tab --}}
                <div class="tab-pane fade" id="activity" role="tabpanel">
                    <div class="info-section">
                        <div class="section-header">
                            <div class="section-icon-box">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h3>{{ $isOwnProfile ? 'My Upcoming Sessions' : 'Upcoming Sessions' }}</h3>
                        </div>
                        
                        @if($activities['upcoming_sessions']->count() > 0)
                            @foreach($activities['upcoming_sessions'] as $session)
                                <div class="session-card">
                                    <div class="session-title">{{ $session->sessionName }}</div>
                                    <div class="session-info">
                                        <div class="session-info-item">
                                            <i class="bi bi-calendar-event"></i>
                                            <span>{{ \Carbon\Carbon::parse($session->sessionDate)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="session-info-item">
                                            <i class="bi bi-clock"></i>
                                            <span>{{ \Carbon\Carbon::parse($session->sessionTime)->format('h:i A') }}</span>
                                        </div>
                                        @if($session->location)
                                            <div class="session-info-item">
                                                <i class="bi bi-geo-alt"></i>
                                                <span>{{ $session->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-box">
                                <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                                <p class="empty-text">{{ $isOwnProfile ? 'You have no upcoming study sessions' : 'No upcoming study sessions' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Blog Posts Tab --}}
                <div class="tab-pane fade" id="blog" role="tabpanel">
                    <div class="info-section">
                        <div class="section-header">
                            <div class="section-icon-box">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <h3>{{ $isOwnProfile ? 'My Blog Posts' : 'Blog Posts' }}</h3>
                        </div>
                        
                        @if($activities['blog_posts']->count() > 0)
                            <div class="row">
                                @foreach($activities['blog_posts'] as $post)
                                    <div class="col-12 mb-3">
                                        <x-blog-card :blog="$post" :showActions="false" />
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-box">
                                <div class="empty-icon"><i class="bi bi-file-earmark-x"></i></div>
                                <p class="empty-text">{{ $isOwnProfile ? 'You haven\'t posted anything yet' : 'This user hasn\'t posted anything yet' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection

