@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<div class="container my-5 profile-page">
    <div class="mx-auto" style="max-width: 1080px;">
        <h3 class="text-center mb-5 fw-semibold">My Profile</h3>

        <!-- SECTION 1: Profile Header -->
        <div class="card p-4 text-center shadow-sm mb-4">
            @php
                $profileImage = $user->userInfo && $user->userInfo->profile_image
                    ? asset('storage/' . $user->userInfo->profile_image)
                    : asset('img/default-profile.png');
            @endphp

            <img  
                src="{{ $profileImage }}" 
                alt="Profile Picture" 
                class="d-block mx-auto rounded-circle border border-2 mb-3"
                style="width: 120px; height: 120px; object-fit: cover; object-position: center;"
            >
            <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
        </div>

        <!-- SECTION 2: User Info -->
        <div class="card p-4 shadow-sm mb-4 mx-auto" style="max-width:1080px;">
            <h5 class="mb-3 fw-semibold text-center">User Information</h5>

            <form>
                <div class="mb-3">
                    <label class="form-label fw-medium">University</label>
                    <input type="text" class="form-control" 
                        value="{{ $user->userInfo->university->uniName ?? 'Not set' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Course</label>
                    <input type="text" class="form-control"
                        value="{{ $user->userInfo->course->courseName ?? 'Not set' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Education Level</label>
                    <input type="text" class="form-control"
                        value="{{ $user->userInfo->educationLevel->edulvlType ?? 'Not set' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">MBTI</label>
                    <input type="text" class="form-control"
                        value="{{ $user->userInfo->mbti->mbti ?? 'Not set' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">About Me</label>
                    <textarea class="form-control" rows="3" readonly>{{ $user->userInfo->aboutMe ?? 'No description yet.' }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Preferred Time</label>
                    <input type="text" class="form-control"
                        value="{{ $user->userInfo && $user->userInfo->preferred_time ? implode(', ', $user->userInfo->preferred_time) : 'Not set' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Preferred Mode</label>
                    <input type="text" class="form-control"
                        value="{{ $user->userInfo && $user->userInfo->preferred_mode ? implode(', ', $user->userInfo->preferred_mode) : 'Not set' }}" readonly>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('profile.info.edit') }}" class="btn btn-outline-primary btn-sm">Edit Info</a>
                </div>
            </form>
        </div>

        <!-- SECTION 3: Change Password -->
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3 fw-semibold text-center text-md-start">Change Password</h5>
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label small">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="form-control form-control-sm" autocomplete="current-password">
                    @if ($errors->updatePassword->get('current_password'))
                        <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small">New Password</label>
                    <input id="password" name="password" type="password" class="form-control form-control-sm" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password'))
                        <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label small">Confirm New Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control form-control-sm" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password_confirmation'))
                        <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-sm">Update Password</button>

                @if (session('status') === 'password-updated')
                    <p class="text-success small mt-2 text-center">Password updated successfully.</p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

