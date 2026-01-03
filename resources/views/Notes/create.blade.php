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

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1f2937;
        transition: all 0.2s;
        background: white;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }

    .form-textarea.content {
        min-height: 200px;
    }

    .form-help {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-help i {
        font-size: 0.875rem;
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

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert ul {
        margin: 0;
        padding: 0 0 0 20px;
    }

    .alert li {
        margin-bottom: 4px;
    }

    .alert li:last-child {
        margin-bottom: 0;
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

    .btn-submit:disabled {
        background: #d1d5db;
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
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
    <a href="{{ route('notes.index') }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back to Notes</span>
    </a>

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">Create New Note</h3>
        <p class="page-subtitle">Organize your study materials and important information</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf

        <div class="form-container">
            
            <!-- Basic Information -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Basic Information
                </h4>
                <p class="section-subtitle">Enter the essential details for your note</p>

                <div class="form-group">
                    <label class="form-label">
                        Note Title <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-input" 
                        placeholder="e.g., Program Comprehension - Chapter 3"
                        value="{{ old('title') }}"
                        required
                        autofocus
                    >
                    <div class="form-help">
                        <i class="bi bi-lightbulb"></i>
                        Use a clear, descriptive title
                    </div>
                    @error('title')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea 
                        name="description" 
                        class="form-textarea" 
                        placeholder="A brief overview of what this note contains..."
                    >{{ old('description') }}</textarea>
                    <div class="form-help">
                        <i class="bi bi-info-circle"></i>
                        Optional: Add a short description to help you remember what this note is about
                    </div>
                    @error('description')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tags</label>
                    <input 
                        type="text" 
                        name="tags" 
                        class="form-input" 
                        placeholder="e.g., SEM, Software Engineering, Final Exam"
                        value="{{ old('tags') }}"
                    >
                    <div class="form-help">
                        <i class="bi bi-tags"></i>
                        Separate tags with commas to organize and filter your notes
                    </div>
                    @error('tags')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Note Content -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Note Content
                </h4>
                <p class="section-subtitle">Write your notes or quick reminders here</p>

                <div class="form-group">
                    <label class="form-label">
                        Content <span class="required">*</span>
                    </label>
                    <textarea 
                        name="content" 
                        class="form-textarea content" 
                        placeholder="Write your notes here...

You can add:
• Key concepts and definitions
• Important formulas or equations
• Study tips and reminders
• Summary points
• Anything else you want to remember"
                        required
                    >{{ old('content') }}</textarea>
                    <div class="form-help">
                        <i class="bi bi-pencil"></i>
                        This is the main content of your note
                    </div>
                    @error('content')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('notes.index') }}" class="btn btn-cancel">
                <i class="bi bi-x-lg"></i>
                Cancel
            </a>
            <button type="submit" class="btn btn-submit">
                <i class="bi bi-check-lg"></i>
                Create Note
            </button>
        </div>
    </form>
</div>

@endsection