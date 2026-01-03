@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">
    <h4 class="fw-semibold mb-4" style="color:#8c52ff;">My Profile</h4>

    <div class="row g-4">
        <!-- PROFILE HEADER CARD -->
        <div class="col-lg-4 col-md-12">
            <div class="card p-4 shadow-sm border-0 rounded-4 h-100">
                <!-- Accent background with gradient -->
                <div class="position-absolute top-0 start-0 w-100" 
                     style="height: 100px; background: linear-gradient(135deg, #8c52ff 0%, #b794f6 100%); border-top-left-radius: 16px; border-top-right-radius: 16px; z-index: 0;">
                </div>

                @php
                    $profileImage = $user->userInfo && $user->userInfo->profile_image
                        ? asset('storage/' . $user->userInfo->profile_image)
                        : asset('img/default-profile.png');
                @endphp

                <!-- Profile Image -->
                <div class="position-relative mb-3 text-center" style="margin-top: 20px; z-index: 1;">
                    <div class="position-relative d-inline-block">
                        <img  
                            src="{{ $profileImage }}" 
                            alt="Profile Picture" 
                            class="rounded-circle border border-4 border-white shadow-sm"
                            style="width: 120px; height: 120px; object-fit: cover;"
                        >
                    </div>
                </div>

                <!-- User Info -->
                <div class="text-center mb-4">
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2 small">{{ $user->email }}</p>
                </div>


                <!-- Quick Info Cards Grid -->
                @if($user->userInfo)
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 text-center">
                            <div class="small text-muted mb-1">Year</div>
                            <div class="fw-semibold small text-dark">{{ $user->userInfo->academicYear ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 text-center">
                            <div class="small text-muted mb-1">Level</div>
                            <div class="fw-semibold small text-dark">{{ $user->userInfo->educationLevel->edulvlType ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 text-center">
                            <div class="small text-muted mb-1">MBTI</div>
                            <div class="fw-semibold small text-dark">{{ $user->userInfo->mbti->mbti ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-2 text-center">
                            <div class="small text-muted mb-1">Status</div>
                            <div class="fw-semibold small">
                                <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.7rem;">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Edit Profile Button -->
                <a href="{{ route('profile.edit') }}" 
                   class="btn btn-sm rounded-pill text-white px-4 py-2 w-100"
                   style="background-color: #8c52ff;">
                   <i class="bi bi-pencil-square me-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- USER INFORMATION CARD -->
        <div class="col-lg-8 col-md-12">
            <div class="card p-4 shadow-sm border-0 rounded-4 h-100">
                <!-- Header with Edit Button -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-person-lines-fill me-2" style="color: #8c52ff;"></i>
                        User Information
                    </h5>
                    <a href="{{ route('profile.info.edit') }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                       <i class="bi bi-pencil me-1"></i> Edit Info
                    </a>
                </div>

                @php
                    $infoSections = [
                        'Academic' => [
                            'University' => $user->userInfo->university->uniName ?? 'Not set',
                            'Course' => $user->userInfo->course->courseName ?? 'Not set',
                            'Year' => $user->userInfo->academicYear ?? 'Not set',
                            'Education Level' => $user->userInfo->educationLevel->edulvlType ?? 'Not set',
                        ],
                        'Personal' => [
                            'MBTI Type' => $user->userInfo->mbti->mbti ?? 'Not set',
                        ],
                        'Preferences' => [
                            'Preferred Time' => $user->userInfo && $user->userInfo->preferred_time ? implode(', ', $user->userInfo->preferred_time) : 'Not set',
                            'Preferred Mode' => $user->userInfo && $user->userInfo->preferred_mode ? implode(', ', $user->userInfo->preferred_mode) : 'Not set',
                        ]
                    ];
                @endphp

                <!-- Info Sections -->
                @foreach($infoSections as $sectionTitle => $fields)
                <div class="mb-4">
                    <h6 class=" small fw-bold mb-3 text-uppercase" style="letter-spacing: 0.5px;">{{ $sectionTitle }}</h6>
                    <div class="row g-3">
                        @foreach($fields as $label => $value)
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <label class="form-label small fw-semibold text-muted mb-1">
                                        {{ $label }}
                                    </label>
                                    <div class="bg-light rounded-3 px-3 py-2 small text-dark">
                                        {{ $value }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- About Me Section -->
                @if($user->userInfo)
                <div>
                    <h6 class="text-muted small fw-semibold mb-3 text-uppercase" style="letter-spacing: 0.5px;">About Me</h6>
                    <div class="bg-light rounded-3 px-3 py-3 small text-dark" style="min-height: 80px; line-height: 1.6;">
                        {{ $user->userInfo->aboutMe ?? 'No description yet.' }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CHANGE PASSWORD -->
    <div class="card p-4 shadow-sm border-0 rounded-4 mb-4 mt-4">
        <h5 class="mb-4 fw-semibold text-center text-md-start">Change Password</h5>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            @foreach(['current_password' => 'Current Password', 'password' => 'New Password', 'password_confirmation' => 'Confirm New Password'] as $name => $label)
                <div class="mb-3">
                    <label for="{{ $name }}" class="form-label small fw-medium">{{ $label }}</label>
                    <input id="{{ $name }}" name="{{ $name }}" type="password" class="form-control rounded-3">
                    @if ($errors->updatePassword->get($name))
                        <div class="text-danger small mt-1">{{ $errors->updatePassword->first($name) }}</div>
                    @endif
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Update Password</button>

            @if (session('status') === 'password-updated')
                <p class="text-success small mt-2 text-center">Password updated successfully.</p>
            @endif
        </form>
    </div>

    <!-- DELETE ACCOUNT -->
    <div class="card p-4 shadow-sm border-0 rounded-4 mb-5">
        <h5 class="mb-3 fw-semibold text-center text-md-start text-danger">Delete Account</h5>
        <p class="text-muted small mb-4">Once you delete your account, all of your data will be permanently removed. This action cannot be undone.</p>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-3">
                <label for="password_delete" class="form-label small fw-medium">Confirm with Password</label>
                <input id="password_delete" name="password" type="password" class="form-control rounded-3" autocomplete="current-password" required>
                @if ($errors->userDeletion->get('password'))
                    <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-danger w-100 rounded-pill py-2" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                Delete Account
            </button>
        </form>
    </div>
</div>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #8c52ff;
        box-shadow: 0 0 0 0.2rem rgba(140, 82, 255, 0.15);
    }

    .btn-outline-primary {
        color: #8c52ff;
        border-color: #8c52ff;
    }

    .btn-outline-primary:hover {
        background-color: #8c52ff;
        border-color: #8c52ff;
        color: white;
    }

    /* Smooth transitions */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection








