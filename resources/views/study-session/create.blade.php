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
    .form-select,
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
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }

    .form-help {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
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

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    /* Radio Group */
    .radio-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .radio-option {
        flex: 1;
        min-width: 140px;
    }

    .radio-option input[type="radio"] {
        display: none;
    }

    .radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        background: #f9fafb;
    }

    .radio-label i {
        font-size: 1.125rem;
    }

    .radio-option input[type="radio"]:checked + .radio-label {
        border-color: var(--bm-purple);
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .radio-label:hover {
        border-color: #d1d5db;
        background: white;
    }

    /* Invite Section */
    .invite-section {
        background: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        padding: 16px;
    }

    .connections-list {
        max-height: 300px;
        overflow-y: auto;
        margin-top: 12px;
    }

    .connection-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .connection-item:hover {
        border-color: #d1d5db;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .connection-item.selected {
        border-color: var(--bm-purple);
        background: var(--bm-purple-lighter);
    }

    .connection-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #d1d5db;
        border-radius: 4px;
        cursor: pointer;
        accent-color: var(--bm-purple);
    }

    .connection-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--bm-purple-lighter);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--bm-purple);
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .connection-info {
        flex: 1;
    }

    .connection-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .connection-email {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .search-box {
        margin-bottom: 12px;
    }

    .search-input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.813rem;
        background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%239ca3af' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E") no-repeat 12px center;
    }

    .selected-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .empty-connections {
        text-align: center;
        padding: 32px 16px;
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .empty-connections i {
        font-size: 2rem;
        margin-bottom: 8px;
        color: #d1d5db;
        display: block;
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

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .alert i {
        font-size: 1.125rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid,
        .form-grid-3 {
            grid-template-columns: 1fr;
        }

        .radio-group {
            flex-direction: column;
        }

        .radio-option {
            min-width: 100%;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        /* Alert Styles */
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
        }

        .alert li {
            margin-bottom: 4px;
        }

        .alert li:last-child {
            margin-bottom: 0;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('study-session.index') }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back</span>
    </a>

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">Create Study Session</h3>
        <p class="page-subtitle">Schedule a new collaborative study session with your connections</p>
    </div>

    <!-- Validation Summary Alert -->
    <div id="validationAlert" class="alert alert-error" style="display: none; margin-bottom: 24px;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul id="validationErrors" style="margin: 8px 0 0 0; padding-left: 20px;">
                <!-- Errors will be inserted here by JavaScript -->
            </ul>
        </div>
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
    <form action="{{ route('study-session.store') }}" method="POST" id="sessionForm">
        @csrf

        <div class="form-container">
            <!-- Basic Information -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Basic Information
                </h4>
                <p class="section-subtitle">Enter the essential details for your study session</p>

                <div class="form-group">
                    <label class="form-label">
                        Session Name <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="sessionName" 
                        class="form-input" 
                        placeholder="e.g., Calculus Final Exam Prep"
                        value="{{ old('sessionName') }}"
                        required
                    >
                    @error('sessionName')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea 
                        name="sessionDetails" 
                        class="form-textarea" 
                        placeholder="Add any additional details about the session..."
                    >{{ old('sessionDetails') }}</textarea>
                    <div class="form-help">Optional: Topics to cover, materials to bring, etc.</div>
                    @error('sessionDetails')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Session Status <span class="required">*</span>
                    </label>
                    <select name="status" class="form-select" required>
                        <option value="planned" {{ old('status') === 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Schedule -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-calendar-event"></i>
                    Schedule
                </h4>
                <p class="section-subtitle">Set the date and time for your session</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Session Date <span class="required">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="sessionDate" 
                            class="form-input" 
                            value="{{ old('sessionDate') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >
                        @error('sessionDate')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Start Time <span class="required">*</span>
                        </label>
                        <input 
                            type="time" 
                            name="sessionTime" 
                            class="form-input" 
                            value="{{ old('sessionTime') }}"
                            required
                        >
                        @error('sessionTime')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">End Time (Optional)</label>
                    <input 
                        type="time" 
                        name="endTime" 
                        class="form-input" 
                        value="{{ old('endTime') }}"
                    >
                    <div class="form-help">Leave empty if duration is flexible</div>
                    @error('endTime')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Session Mode -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-geo-alt"></i>
                    Session Mode
                </h4>
                <p class="section-subtitle">Choose how the session will be conducted</p>

                <div class="form-group">
                    <div class="radio-group">
                        <div class="radio-option">
                            <input 
                                type="radio" 
                                name="sessionMode" 
                                id="mode-online" 
                                value="online"
                                {{ old('sessionMode') === 'online' ? 'checked' : '' }}
                                onchange="toggleModeFields()"
                                required
                            >
                            <label for="mode-online" class="radio-label">
                                <i class="bi bi-camera-video"></i>
                                Online
                            </label>
                        </div>
                        <div class="radio-option">
                            <input 
                                type="radio" 
                                name="sessionMode" 
                                id="mode-face" 
                                value="face-to-face"
                                {{ old('sessionMode') === 'face-to-face' ? 'checked' : '' }}
                                onchange="toggleModeFields()"
                                required
                            >
                            <label for="mode-face" class="radio-label">
                                <i class="bi bi-people"></i>
                                Face-to-Face
                            </label>
                        </div>
                    </div>
                    @error('sessionMode')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Online Mode Fields -->
                <div id="online-fields" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">
                            Meeting Link <span class="required">*</span>
                        </label>
                        <input 
                            type="url" 
                            name="meeting_link" 
                            id="meeting_link"
                            class="form-input" 
                            placeholder="https://zoom.us/j/123456789"
                            value="{{ old('meeting_link', $session->meeting_link ?? '') }}"
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Zoom, Google Meet, Microsoft Teams, etc. Must be a valid URL.
                        </div>
                        <div id="meeting_link_error" class="form-error" style="display: none;">
                            <i class="bi bi-exclamation-circle"></i>
                            <span id="meeting_link_error_text"></span>
                        </div>
                        @error('meeting_link')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Face-to-Face Mode Fields -->
                <div id="face-fields" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">
                            Location <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location"
                            class="form-input" 
                            placeholder="e.g., Library Study Room 3A"
                            value="{{ old('location', $session->location ?? '') }}"
                        >
                        <div class="form-help">
                            <i class="bi bi-info-circle"></i>
                            Specify the physical meeting location
                        </div>
                        <div id="location_error" class="form-error" style="display: none;">
                            <i class="bi bi-exclamation-circle"></i>
                            <span id="location_error_text"></span>
                        </div>
                        @error('location')
                            <div class="form-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
            <!-- Invite Participants -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-people"></i>
                    Invite Participants
                    @if($connections->isNotEmpty())
                        <span class="selected-count" id="selectedCount">
                            <i class="bi bi-check-circle-fill"></i>
                            <span id="countText">0 selected</span>
                        </span>
                    @endif
                </h4>
                <p class="section-subtitle">Select connections to invite to this session</p>

                @if($connections->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <div>
                            You don't have any connections yet. 
                            <a href="{{ route('study-partner.index') }}" style="color: inherit; font-weight: 600; text-decoration: underline;">
                                Find study partners
                            </a> to invite them to your sessions.
                        </div>
                    </div>
                @else
                    <div class="invite-section">
                        <div class="search-box">
                            <input 
                                type="text" 
                                class="search-input" 
                                id="searchConnections"
                                placeholder="Search connections..."
                            >
                        </div>

                        <div class="connections-list" id="connectionsList">
                            @foreach($connections as $connection)
                                <label class="connection-item" data-name="{{ strtolower($connection->name) }}" data-email="{{ strtolower($connection->email) }}">
                                    <input 
                                        type="checkbox" 
                                        name="invited_users[]" 
                                        value="{{ $connection->id }}"
                                        class="connection-checkbox"
                                        onchange="updateSelectedCount()"
                                    >
                                    <div class="connection-avatar">
                                        {{ strtoupper(substr($connection->name, 0, 1)) }}
                                    </div>
                                    <div class="connection-info">
                                        <div class="connection-name">{{ $connection->name }}</div>
                                        <div class="connection-email">{{ $connection->email }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('study-session.index') }}" class="btn btn-cancel">
                <i class="bi bi-x-lg"></i>
                Cancel
            </a>
            <button type="submit" class="btn btn-submit">
                <i class="bi bi-check-lg"></i>
                Create Session
            </button>
        </div>
    </form>
</div>

<script>
    // Toggle mode-specific fields
    function toggleModeFields() {
        const mode = document.querySelector('input[name="sessionMode"]:checked')?.value;
        const onlineFields = document.getElementById('online-fields');
        const faceFields = document.getElementById('face-fields');
        const meetingLink = document.getElementById('meeting_link');
        const location = document.getElementById('location');

        if (mode === 'online') {
            onlineFields.style.display = 'block';
            faceFields.style.display = 'none';
            
            // Make meeting link required, location not required
            meetingLink.required = true;
            location.required = false;
            location.value = ''; // Clear location when switching to online
        } else if (mode === 'face-to-face') {
            onlineFields.style.display = 'none';
            faceFields.style.display = 'block';
            
            // Make location required, meeting link not required
            location.required = true;
            meetingLink.required = false;
            meetingLink.value = ''; // Clear meeting link when switching to face-to-face
        } else {
            // No mode selected
            onlineFields.style.display = 'none';
            faceFields.style.display = 'none';
            meetingLink.required = false;
            location.required = false;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleModeFields();
    });

    // Show validation errors
    function showValidationErrors(errors) {
        const alertBox = document.getElementById('validationAlert');
        const errorsList = document.getElementById('validationErrors');
        
        // Clear previous errors
        errorsList.innerHTML = '';
        
        // Add new errors
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorsList.appendChild(li);
        });
        
        // Show alert
        alertBox.style.display = 'flex';
        
        // Scroll to alert
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Hide validation errors
    function hideValidationErrors() {
        const alertBox = document.getElementById('validationAlert');
        alertBox.style.display = 'none';
    }

    // Add visual error state to field
    function addFieldError(fieldId, show = true) {
        const field = document.getElementById(fieldId);
        if (field) {
            if (show) {
                field.style.borderColor = '#dc2626';
                field.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
            } else {
                field.style.borderColor = '';
                field.style.boxShadow = '';
            }
        }
    }

    // Clear all field errors
    function clearFieldErrors() {
        ['meeting_link', 'location'].forEach(fieldId => {
            addFieldError(fieldId, false);
        });
    }

    // Form validation
    document.getElementById('sessionForm').addEventListener('submit', function(e) {
        // Clear previous errors
        hideValidationErrors();
        clearFieldErrors();
        
        const errors = [];
        const sessionTime = document.querySelector('input[name="sessionTime"]').value;
        const endTime = document.querySelector('input[name="endTime"]').value;
        const mode = document.querySelector('input[name="sessionMode"]:checked')?.value;
        const meetingLink = document.getElementById('meeting_link').value.trim();
        const location = document.getElementById('location').value.trim();
        const sessionName = document.querySelector('input[name="sessionName"]').value.trim();

        // Check if session name is provided
        if (!sessionName) {
            errors.push('Session name is required');
        }

        // Check if session mode is selected
        if (!mode) {
            errors.push('Please select a session mode (Online or Face-to-Face)');
        }

        // Check if meeting link is provided for online mode
        if (mode === 'online' && !meetingLink) {
            errors.push('Meeting link is required for online sessions');
            addFieldError('meeting_link', true);
        }

        // Check if location is provided for face-to-face mode
        if (mode === 'face-to-face' && !location) {
            errors.push('Location is required for face-to-face sessions');
            addFieldError('location', true);
        }

        // Validate URL format for meeting link
        if (mode === 'online' && meetingLink) {
            try {
                new URL(meetingLink);
            } catch (_) {
                errors.push('Meeting link must be a valid URL (e.g., https://zoom.us/j/123456789)');
                addFieldError('meeting_link', true);
            }
        }

        // Check if end time is before start time
        if (endTime && sessionTime) {
            const [startH, startM] = sessionTime.split(':').map(Number);
            const [endH, endM] = endTime.split(':').map(Number);
            if (endH * 60 + endM <= startH * 60 + startM) {
                errors.push('End time must be after start time');
            }
        }

        // If there are errors, prevent submission and show them
        if (errors.length > 0) {
            e.preventDefault();
            showValidationErrors(errors);
            return false;
        }
    });

    // Clear error highlighting when user starts typing
    document.getElementById('meeting_link')?.addEventListener('input', function() {
        addFieldError('meeting_link', false);
    });

    document.getElementById('location')?.addEventListener('input', function() {
        addFieldError('location', false);
    });

    // Hide alert when user interacts with form
    document.getElementById('sessionForm').addEventListener('input', function() {
        const alertBox = document.getElementById('validationAlert');
        if (alertBox.style.display !== 'none') {
            // Only hide if user has started fixing errors
            setTimeout(() => {
                const mode = document.querySelector('input[name="sessionMode"]:checked')?.value;
                const meetingLink = document.getElementById('meeting_link').value.trim();
                const location = document.getElementById('location').value.trim();
                
                if ((mode === 'online' && meetingLink) || (mode === 'face-to-face' && location)) {
                    hideValidationErrors();
                }
            }, 500);
        }
    });

    // Update selected count (for create.blade.php only - will be ignored in edit.blade.php if function doesn't exist)
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.connection-checkbox:checked');
        const count = checkboxes.length;
        const countText = document.getElementById('countText');
        
        if (countText) {
            countText.textContent = count === 1 ? '1 selected' : `${count} selected`;
        }

        // Update visual state of connection items
        document.querySelectorAll('.connection-item').forEach(item => {
            const checkbox = item.querySelector('.connection-checkbox');
            if (checkbox.checked) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        });
    }

    // Search connections
    document.getElementById('searchConnections')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.connection-item');

        items.forEach(item => {
            const name = item.dataset.name;
            const email = item.dataset.email;
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Highlight selected connections
    document.querySelectorAll('.connection-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const item = this.closest('.connection-item');
            if (this.checked) {
                item.style.borderColor = 'var(--bm-purple)';
                item.style.backgroundColor = 'var(--bm-purple-lighter)';
            } else {
                item.style.borderColor = '#e5e7eb';
                item.style.backgroundColor = 'white';
            }
        });
    });

    // Function to remove participant (for edit.blade.php only)
    function removeParticipant(inviteId) {
        if (confirm('Remove this participant?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/invites/' + inviteId + '/cancel';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection