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

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
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

    /* Resources Management */
    .resources-section {
        background: #f9fafb;
        border-radius: 8px;
        padding: 16px;
    }

    .add-resource-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .add-resource-title {
        font-size: 0.938rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .resource-count-badge {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Existing Resources */
    .existing-resources {
        margin-bottom: 20px;
    }

    .resource-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .resource-item:last-child {
        margin-bottom: 0;
    }

    .resource-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .resource-icon {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .resource-icon.pdf {
        background: #fee2e2;
        color: #dc2626;
    }

    .resource-icon.image {
        background: #dbeafe;
        color: #2563eb;
    }

    .resource-icon.link {
        background: #f3e8ff;
        color: #9333ea;
    }

    .resource-info {
        flex: 1;
    }

    .resource-name {
        font-size: 0.813rem;
        color: #111827;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .resource-meta {
        font-size: 0.688rem;
        color: #9ca3af;
    }

    .resource-btn-delete {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: none;
        background: #f9fafb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.813rem;
    }

    .resource-btn-delete:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Add Resource Forms */
    .add-resource-forms {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .add-resource-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
    }

    .add-resource-card-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .add-resource-card-title i {
        font-size: 1rem;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input {
        display: none;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        color: #6b7280;
        font-size: 0.813rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-input-label:hover {
        border-color: var(--bm-purple);
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .file-input-label i {
        font-size: 1.125rem;
    }

    .file-selected {
        margin-top: 8px;
        padding: 8px 12px;
        background: var(--bm-purple-lighter);
        border-radius: 6px;
        font-size: 0.75rem;
        color: var(--bm-purple);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .file-selected i {
        font-size: 0.875rem;
    }

    .btn-add-resource {
        width: 100%;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        background: var(--bm-purple);
        color: white;
        font-size: 0.813rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
    }

    .btn-add-resource:hover {
        background: var(--bm-purple-dark);
    }

    .btn-add-resource:disabled {
        background: #d1d5db;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-resources {
        text-align: center;
        padding: 24px 16px;
        color: #9ca3af;
        font-size: 0.813rem;
    }

    .empty-resources i {
        font-size: 1.5rem;
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
    <a href="{{ route('notes.show', $note->id) }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back to Note</span>
    </a>

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">Edit Note</h3>
        <p class="page-subtitle">Update your note details and manage resources</p>
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
    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-container">
            
            <!-- Basic Information -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Basic Information
                </h4>
                <p class="section-subtitle">Update the essential details for your note</p>

                <div class="form-group">
                    <label class="form-label">
                        Note Title <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-input" 
                        placeholder="e.g., Program Comprehension - Chapter 3"
                        value="{{ old('title', $note->title) }}"
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
                    >{{ old('description', $note->description) }}</textarea>
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
                        value="{{ old('tags', $note->tags) }}"
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
                <p class="section-subtitle">Update your notes or quick reminders</p>

                <div class="form-group">
                    <label class="form-label">
                        Content <span class="required">*</span>
                    </label>
                    <textarea 
                        name="content" 
                        class="form-textarea content" 
                        placeholder="Write your notes here..."
                        required
                    >{{ old('content', $note->content) }}</textarea>
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
            <a href="{{ route('notes.show', $note->id) }}" class="btn btn-cancel">
                <i class="bi bi-x-lg"></i>
                Cancel
            </a>
            <button type="submit" class="btn btn-submit">
                <i class="bi bi-check-lg"></i>
                Update Note
            </button>
        </div>
    </form>

    <!-- Resources Management (Separate from main form) -->
    <div class="form-container" style="margin-top: 20px;">
        <div class="form-section">
            <h4 class="section-title">
                <i class="bi bi-paperclip"></i>
                Resources Management
            </h4>
            <p class="section-subtitle">Add or remove files and links attached to this note</p>

            <div class="resources-section">
                    
                    <!-- Existing Resources -->
                    @if($note->hasResources())
                        <div class="add-resource-header">
                            <div class="add-resource-title">
                                <i class="bi bi-files"></i>
                                Current Resources
                                <span class="resource-count-badge">{{ $note->getResourcesCount() }}</span>
                            </div>
                        </div>

                        <div class="existing-resources">
                            @foreach($note->resources as $resource)
                                @php
                                    $isFile = $resource->resource_type === 'file';
                                    $extension = $isFile ? strtolower(pathinfo($resource->resource_file_path, PATHINFO_EXTENSION)) : null;
                                    $isPdf = $extension === 'pdf';
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="resource-item">
                                    <div class="resource-left">
                                        <div class="resource-icon {{ $isPdf ? 'pdf' : ($isImage ? 'image' : 'link') }}">
                                            @if($isPdf)
                                                <i class="bi bi-file-pdf"></i>
                                            @elseif($isImage)
                                                <i class="bi bi-file-image"></i>
                                            @else
                                                <i class="bi bi-link-45deg"></i>
                                            @endif
                                        </div>
                                        <div class="resource-info">
                                            <div class="resource-name">
                                                {{ $resource->resource_name ?? ($isFile ? basename($resource->resource_file_path) : 'Link') }}
                                            </div>
                                            <div class="resource-meta">
                                                @if($isFile)
                                                    {{ strtoupper($extension) }}
                                                @else
                                                    {{ Str::limit($resource->resource_link, 40) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('notes.resources.destroy', $resource->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Delete this resource?');" 
                                          style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="resource-btn-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-resources">
                            <i class="bi bi-inbox"></i>
                            <div>No resources added yet. Add files or links below.</div>
                        </div>
                    @endif

                    <!-- Add New Resources -->
                    <div class="add-resource-forms">
                        
                        <!-- Upload File -->
                        <div class="add-resource-card">
                            <div class="add-resource-card-title">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                                Upload File
                            </div>
                            <form action="{{ route('notes.resources.store', $note->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="resource_type" value="file">
                                
                                <div class="form-group">
                                    <div class="file-input-wrapper">
                                        <input 
                                            type="file" 
                                            name="file" 
                                            id="fileInput" 
                                            class="file-input"
                                            accept=".pdf,.jpg,.jpeg,.png,.gif,.webp"
                                            onchange="showFileName(this)"
                                        >
                                        <label for="fileInput" class="file-input-label">
                                            <i class="bi bi-cloud-upload"></i>
                                            <span>Choose File (PDF or Image)</span>
                                        </label>
                                        <div id="fileSelected" class="file-selected" style="display: none;">
                                            <i class="bi bi-file-check"></i>
                                            <span id="fileName"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">File Name (Optional)</label>
                                    <input 
                                        type="text" 
                                        name="resource_name" 
                                        class="form-input" 
                                        placeholder="e.g., Chapter 3 Notes"
                                    >
                                </div>

                                <button type="submit" class="btn-add-resource" id="uploadBtn" disabled>
                                    <i class="bi bi-upload"></i>
                                    <span>Upload File</span>
                                </button>
                            </form>
                        </div>

                        <!-- Add Link -->
                        <div class="add-resource-card">
                            <div class="add-resource-card-title">
                                <i class="bi bi-link-45deg"></i>
                                Add Link
                            </div>
                            <form action="{{ route('notes.resources.store', $note->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="resource_type" value="link">
                                
                                <div class="form-group">
                                    <label class="form-label">URL <span class="required">*</span></label>
                                    <input 
                                        type="url" 
                                        name="link" 
                                        class="form-input" 
                                        placeholder="https://example.com"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Link Name (Optional)</label>
                                    <input 
                                        type="text" 
                                        name="resource_name" 
                                        class="form-input" 
                                        placeholder="e.g., Reference Article"
                                    >
                                </div>

                                <button type="submit" class="btn-add-resource">
                                    <i class="bi bi-plus-lg"></i>
                                    <span>Add Link</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function showFileName(input) {
        const fileSelected = document.getElementById('fileSelected');
        const fileName = document.getElementById('fileName');
        const uploadBtn = document.getElementById('uploadBtn');

        if (input.files && input.files[0]) {
            fileName.textContent = input.files[0].name;
            fileSelected.style.display = 'flex';
            uploadBtn.disabled = false;
        } else {
            fileSelected.style.display = 'none';
            uploadBtn.disabled = true;
        }
    }
</script>

@endsection