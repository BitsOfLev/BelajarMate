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

    .page-subtitle {
        color: #6b7280;
        font-size: 0.938rem;
    }

    /* Form Container */
    .form-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .form-section {
        padding: 24px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--bm-purple);
        font-size: 1.125rem;
    }

    .section-subtitle {
        font-size: 0.813rem;
        color: #6b7280;
        margin-bottom: 20px;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-label .required {
        color: #dc2626;
        margin-left: 2px;
    }

    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1f2937;
        transition: all 0.2s;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .form-help {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-error {
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-error i {
        font-size: 0.875rem;
    }

    /* Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 0.938rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cancel {
        background: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
    }

    .btn-cancel:hover {
        background: #f9fafb;
        color: #374151;
    }

    .btn-submit {
        background: var(--bm-purple);
        color: white;
    }

    .btn-submit:hover {
        background: var(--bm-purple-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Alert */
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.875rem;
    }

    .alert i {
        font-size: 1.125rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #86efac;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .alert li {
        margin-bottom: 4px;
    }

    .alert li:last-child {
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('pomodoro.index') }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">Edit Pomodoro Preset</h3>
        <p class="page-subtitle">Update your focus session timings</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('pomodoro.presets.update', $preset) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-container">
            <!-- Basic Information -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Basic Information
                </h4>
                <p class="section-subtitle">Update your preset name</p>

                <div class="form-group">
                    <label class="form-label">
                        Preset Name <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-input" 
                        placeholder="e.g., Deep Focus, Quick Study, Exam Prep"
                        value="{{ old('title', $preset->title) }}"
                        required
                    >
                    <div class="form-help">
                        <i class="bi bi-info-circle"></i>
                        Choose a descriptive name to easily identify this preset
                    </div>
                    @error('title')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Session Timings -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-clock"></i>
                    Session Timings
                </h4>
                <p class="section-subtitle">Update your work and break durations</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Work Duration <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="work_minutes" 
                            class="form-input" 
                            value="{{ old('work_minutes', $preset->work_minutes) }}" 
                            min="1" 
                            max="120"
                            placeholder="25"
                            required
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Focus time (1-120 minutes)
                        </div>
                        @error('work_minutes')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Short Break <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="short_break_minutes" 
                            class="form-input" 
                            value="{{ old('short_break_minutes', $preset->short_break_minutes) }}" 
                            min="1" 
                            max="30"
                            placeholder="5"
                            required
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Quick break (1-30 minutes)
                        </div>
                        @error('short_break_minutes')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Long Break <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="long_break_minutes" 
                            class="form-input" 
                            value="{{ old('long_break_minutes', $preset->long_break_minutes) }}" 
                            min="1" 
                            max="60"
                            placeholder="15"
                            required
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Extended break (1-60 minutes)
                        </div>
                        @error('long_break_minutes')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Work Cycles <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="work_cycles" 
                            class="form-input" 
                            value="{{ old('work_cycles', $preset->work_cycles) }}" 
                            min="1" 
                            max="10"
                            placeholder="4"
                            required
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Cycles before long break (1-10)
                        </div>
                        @error('work_cycles')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('pomodoro.index') }}" class="btn btn-cancel">
                <i class="bi bi-x-lg"></i>
                Cancel
            </a>
            <button type="submit" class="btn btn-submit">
                <i class="bi bi-check-lg"></i>
                Update Preset
            </button>
        </div>
    </form>
</div>

@endsection