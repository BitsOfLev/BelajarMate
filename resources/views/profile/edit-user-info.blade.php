@extends('layouts.main')

@section('title', 'Edit User Information')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('profile.view') }}" 
        class="btn btn-sm btn-outline-secondary rounded-circle me-3 d-flex align-items-center justify-content-center"
        style="width: 36px; height: 36px; padding: 0;">
            <i class='bx bx-arrow-back'></i>
        </a>
        <h4 class="fw-semibold mb-0" style="color:#8c52ff;">Edit User Information</h4>
    </div>
    
    {{-- Success message --}}
    @if(session('status'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    @if(session('redirect'))
        <script>
            setTimeout(function() {
                window.location.href = "{{ session('redirect') }}";
            }, 2000);
        </script>
    @endif

    <div class="card p-4 shadow-sm border-0 rounded-4 mb-4">
        <form method="POST" action="{{ route('profile.info.update') }}">
            @csrf
            @method('PATCH')

            {{-- ACADEMIC SECTION --}}
            <div class="mb-4 pb-4 border-bottom">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-mortarboard me-2" style="color: #8c52ff;"></i>
                    Academic Information
                </h5>
                <div class="row g-3">
                    {{-- UNIVERSITY --}}
                    <div class="col-12 col-md-6">
                        <label for="uniID" class="form-label small fw-semibold text-muted">University</label>
                        <select id="uniID" name="uniID" class="form-select rounded-3"
                            onchange="toggleOtherField('uniID','otherUni')"
                            {{ $pendingUni ? 'disabled' : '' }}>
                            <option value="">Select University</option>
                            @foreach($universities as $uni)
                                <option value="{{ $uni->uniID }}" {{ old('uniID', $userInfo->uniID ?? '') == $uni->uniID ? 'selected' : '' }}>
                                    {{ $uni->uniName }}
                                </option>
                            @endforeach
                            <option value="other" {{ $pendingUni || old('uniID') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>

                        @if($pendingUni)
                            <div class="alert alert-warning mt-2 py-2 px-3 small mb-0 rounded-3">
                                <i class="bi bi-clock-history me-1"></i>
                                "{{ $pendingUni->uniName }}" is pending approval
                            </div>
                        @endif

                        <input type="text" id="otherUni" name="other_uni" class="form-control rounded-3 mt-2" placeholder="Enter your university"
                            value="{{ old('other_uni', $pendingUni->uniName ?? '') }}"
                            style="display: {{ $pendingUni || old('uniID') == 'other' ? 'block' : 'none' }};"
                            {{ $pendingUni ? 'readonly' : '' }}>
                    </div>

                    {{-- COURSE --}}
                    <div class="col-12 col-md-6">
                        <label for="courseID" class="form-label small fw-semibold text-muted">Course</label>
                        <select id="courseID" name="courseID" class="form-select rounded-3"
                            onchange="toggleOtherField('courseID','otherCourse')"
                            {{ $pendingCourse ? 'disabled' : '' }}>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->courseID }}" {{ old('courseID', $userInfo->courseID ?? '') == $course->courseID ? 'selected' : '' }}>
                                    {{ $course->courseName }}
                                </option>
                            @endforeach
                            <option value="other" {{ $pendingCourse || old('courseID') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>

                        @if($pendingCourse)
                            <div class="alert alert-warning mt-2 py-2 px-3 small mb-0 rounded-3">
                                <i class="bi bi-clock-history me-1"></i>
                                "{{ $pendingCourse->courseName }}" is pending approval
                            </div>
                        @endif

                        <input type="text" id="otherCourse" name="other_course" class="form-control rounded-3 mt-2" placeholder="Enter your course"
                            value="{{ old('other_course', $pendingCourse->courseName ?? '') }}"
                            style="display: {{ $pendingCourse || old('courseID') == 'other' ? 'block' : 'none' }};"
                            {{ $pendingCourse ? 'readonly' : '' }}>
                    </div>

                    {{-- EDUCATION LEVEL --}}
                    <div class="col-12 col-md-6">
                        <label for="edulvlID" class="form-label small fw-semibold text-muted">Education Level</label>
                        <select id="edulvlID" name="edulvlID" class="form-select rounded-3">
                            <option value="">Select Level</option>
                            @foreach($levels as $lvl)
                                <option value="{{ $lvl->edulvlID }}" {{ old('edulvlID', $userInfo->edulvlID ?? '') == $lvl->edulvlID ? 'selected' : '' }}>
                                    {{ $lvl->edulvlType }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ACADEMIC YEAR --}}
                    <div class="col-12 col-md-6">
                        <label for="academicYear" class="form-label small fw-semibold text-muted">Academic Year</label>
                        <input type="number" 
                            id="academicYear" 
                            name="academicYear" 
                            value="{{ old('academicYear', $userInfo->academicYear ?? '') }}" 
                            class="form-control rounded-3" 
                            placeholder="e.g., 1, 2" 
                            min="1" 
                            max="10" 
                            step="1">
                    </div>
                </div>
            </div>

            {{-- PERSONAL SECTION --}}
            <div class="mb-4 pb-4 border-bottom">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-person me-2" style="color: #8c52ff;"></i>
                    Personal Information
                </h5>
                <div class="row g-3">
                    {{-- MBTI --}}
                    <div class="col-12 col-md-6">
                        <label for="mbtiID" class="form-label small fw-semibold text-muted">MBTI Type</label>
                        <select id="mbtiID" name="mbtiID" class="form-select rounded-3">
                            <option value="">Select MBTI</option>
                            @foreach($mbtiList as $type)
                                <option value="{{ $type->mbtiID }}" {{ old('mbtiID', $userInfo->mbtiID ?? '') == $type->mbtiID ? 'selected' : '' }}>
                                    {{ $type->mbti }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <a href="https://www.16personalities.com/free-personality-test" target="_blank" class="text-decoration-none">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Take the test here
                            </a>
                        </small>
                    </div>

                    {{-- ABOUT ME --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <label for="aboutMe" class="form-label small fw-semibold text-muted">About Me</label>
                            <span id="charCount" class="small text-muted">0 / 1000</span>
                        </div>

                        <textarea 
                            id="aboutMe" 
                            name="aboutMe" 
                            rows="5" 
                            class="form-control rounded-3" 
                            maxlength="1000"
                            placeholder="Share more to connect better! Tell us about your major, subjects, and study vibe...">{{ old('aboutMe', $userInfo->aboutMe ?? '') }}</textarea>
                        
                        <div class="form-text mt-2" style="font-size: 0.85rem;">
                            <i class="bi bi-info-circle me-1"></i> 
                            <strong>Tip:</strong> A detailed description makes it much easier for the right study partners to find and connect with you!
                        </div>
                    </div>
                </div>
            </div>

            {{-- PREFERENCES SECTION --}}
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-sliders me-2" style="color: #8c52ff;"></i>
                    Study Preferences
                </h5>
                <div class="row g-4">
                    {{-- PREFERRED TIME --}}
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Preferred Study Time</label>
                        @php
                            $times = ['morning','noon','evening','night','late night'];
                            $selectedTimes = old('preferred_time') 
                                ?? (isset($userInfo->preferred_time) 
                                    ? (is_array($userInfo->preferred_time) ? $userInfo->preferred_time : explode(',', $userInfo->preferred_time)) 
                                    : []);
                        @endphp
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($times as $time)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="preferred_time[]" value="{{ $time }}" id="time_{{ $time }}" {{ in_array($time, $selectedTimes) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="time_{{ $time }}">{{ ucwords($time) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PREFERRED MODE --}}
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Preferred Study Mode</label>
                        @php
                        $modes = ['online','offline','hybrid'];
                        $selectedModes = old('preferred_mode') 
                            ?? (isset($userInfo->preferred_mode) 
                                ? (is_array($userInfo->preferred_mode) ? $userInfo->preferred_mode : explode(',', $userInfo->preferred_mode)) 
                                : []);
                        @endphp
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($modes as $mode)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="preferred_mode[]" value="{{ $mode }}" id="mode_{{ $mode }}" {{ in_array($mode, $selectedModes) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="mode_{{ $mode }}">{{ ucfirst($mode) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- BUTTONS --}}
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

<script>
    function toggleOtherField(selectId, inputId) {
        const select = document.getElementById(selectId);
        const input = document.getElementById(inputId);
        input.style.display = (select.value === 'other') ? 'block' : 'none';
    }

    const textarea = document.getElementById('aboutMe');
    const charCount = document.getElementById('charCount');
    const maxChars = 1000;

    textarea.addEventListener('input', () => {
        const remaining = textarea.value.length;
        charCount.textContent = `${remaining} / ${maxChars}`;
        
        // Optional: Turn text red when hitting the limit
        if (remaining >= maxChars) {
            charCount.classList.replace('text-muted', 'text-danger');
        } else {
            charCount.classList.replace('text-danger', 'text-muted');
        }
    });

    // Run once on page load to account for existing text (old input)
    window.addEventListener('load', () => {
        charCount.textContent = `${textarea.value.length} / ${maxChars}`;
    });
    </script>

    <style>
    .form-control:focus,
    .form-select:focus {
        border-color: #8c52ff;
        box-shadow: 0 0 0 0.2rem rgba(140, 82, 255, 0.15);
    }

    .form-check-input:checked {
        background-color: #8c52ff;
        border-color: #8c52ff;
    }

    .form-check-input:focus {
        border-color: #8c52ff;
        box-shadow: 0 0 0 0.2rem rgba(140, 82, 255, 0.15);
    }
</style>
@endsection



