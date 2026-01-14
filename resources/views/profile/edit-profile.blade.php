@extends('layouts.main')

@section('title', 'Edit Profile')

@section('content')

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #8c52ff;
        box-shadow: 0 0 0 0.2rem rgba(140, 82, 255, 0.15);
    } 

    #success-alert {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert {
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from { 
            opacity: 0; 
            transform: translateY(-20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
</style>

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('profile.view') }}" 
        class="btn btn-sm btn-outline-secondary rounded-circle me-3 d-flex align-items-center justify-content-center"
        style="width: 36px; height: 36px; padding: 0;">
            <i class='bx bx-arrow-back'></i>
        </a>
        <h4 class="fw-semibold mb-0" style="color:#8c52ff;">Edit Profile</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card p-4 shadow-sm border-0 rounded-4">
                
                {{-- Email Verification Status --}}
                @if (session('status') === 'email-verification-sent')
                    <div class="alert alert-warning rounded-3 mb-4 border-0" style="background-color: #fff3cd;">
                        <div class="d-flex align-items-start">
                            <i class='bx bx-info-circle fs-4 me-2' style="color: #856404;"></i>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #856404;">Email Verification Required</h6>
                                <p class="mb-1 small" style="color: #856404;">{{ session('message') }}</p>
                                <p class="mb-0 small" style="color: #856404;">Check your new email inbox and click the verification link.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
                    <div class="alert alert-danger rounded-3 mb-4 border-0" style="background-color: #f8d7da;">
                        <div class="d-flex align-items-start">
                            <i class='bx bx-error-circle fs-4 me-2' style="color: #721c24;"></i>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1" style="color: #721c24;">Email Not Verified</h6>
                                <p class="mb-2 small" style="color: #721c24;">You must verify your email address to access all features.</p>
                                
                                <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1">
                                        <i class='bx bx-envelope me-1'></i> Resend Verification Email
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Success message --}}
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success rounded-3 mb-4" id="success-alert">
                        <i class="bi bi-check-circle me-2"></i>
                        Profile updated successfully! Redirecting...
                    </div>

                    <script>
                        setTimeout(function() {
                            window.location.href = "{{ route('profile.view') }}";
                        }, 2000);
                    </script>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Picture --}}
                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block mb-3">
                            @if ($user->userInfo && $user->userInfo->profile_image)
                                <img src="{{ asset('storage/' . $user->userInfo->profile_image) }}" 
                                     alt="Profile Picture" 
                                     class="rounded-circle border border-3 border-light shadow-sm"
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     id="preview-image">
                            @else
                                <img src="{{ asset('img/default-profile.png') }}" 
                                     alt="Default Picture" 
                                     class="rounded-circle border border-3 border-light shadow-sm"
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     id="preview-image">
                            @endif
                            <label for="profile_photo" 
                                class="position-absolute bottom-0 end-0 d-flex align-items-center justify-content-center rounded-circle text-white"
                                style="background-color: #8c52ff; width: 36px; height: 36px; padding: 0; cursor: pointer; z-index: 2;">
                                <i class='bx bx-camera'></i>
                            </label>
                        </div>
                        <input type="file" 
                               id="profile_photo" 
                               name="profile_photo" 
                               class="d-none @error('profile_photo') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(event)">
                        @error('profile_photo')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-muted">Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               class="form-control rounded-3 @error('name') is-invalid @enderror" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-muted">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control rounded-3 @error('email') is-invalid @enderror" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="mb-4">
                        <label for="gender" class="form-label small fw-semibold text-muted">Gender</label>
                        <select id="gender" 
                                name="gender" 
                                class="form-select rounded-3 @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            @php
                                $currentGender = old('gender', $user->gender);
                            @endphp
                            <option value="male" {{ $currentGender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $currentGender === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="prefer_not_to_say" {{ $currentGender === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                        <button type="submit" 
                                class="btn btn-sm rounded-pill text-white px-4 py-2 flex-md-grow-0"
                                style="background-color: #8c52ff; min-width: 120px;">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                        </button>

                        <a href="{{ route('profile.view') }}" 
                        class="btn btn-sm btn-outline-secondary rounded-pill px-4 py-2 flex-md-grow-0"
                        style="min-width: 120px;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection






