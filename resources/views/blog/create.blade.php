@extends('layouts.main')

@section('content')

<style>
    body { background: #fafbfc; }
    .page-header { margin-bottom: 24px; }
    
    /* Navigation Tabs */
    .blog-nav-tabs { 
        background: white; 
        padding: 12px 20px; 
        border-radius: 12px; 
        border: 1px solid #f3f4f6; 
        margin-bottom: 24px; 
        display: flex; 
        gap: 8px; 
        flex-wrap: wrap;
    }
    .nav-tab {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f9fafb;
    }
    .nav-tab:hover {
        background: #f3f4f6;
        color: #7c3aed;
    }
    .nav-tab.active {
        background: #7c3aed;
        color: white;
    }
    
    /* Form Container */
    .form-container { 
        background: white; 
        padding: 28px; 
        border-radius: 12px; 
        border: 1px solid #f3f4f6; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); 
        max-width: 800px; 
        margin: auto; 
    }
    
    /* Form Groups */
    .form-group { 
        margin-bottom: 20px; 
    }
    .form-label { 
        font-weight: 600; 
        color: #374151; 
        margin-bottom: 8px; 
        display: block;
        font-size: 0.938rem;
    }
    .required { 
        color: #dc2626; 
    }
    
    /* Inputs */
    input[type="text"], 
    textarea, 
    select, 
    input[type="file"] { 
        width: 100%;
        padding: 12px; 
        border: 1px solid #d1d5db; 
        border-radius: 8px; 
        font-size: 0.938rem; 
        color: #111827; 
        transition: all 0.2s;
    }
    input[type="text"]:focus, 
    textarea:focus, 
    select:focus { 
        border-color: #7c3aed; 
        outline: none; 
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    textarea { 
        min-height: 200px; 
        resize: vertical; 
        font-family: inherit;
    }
    
    /* File Input Styling */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        background: #f9fafb;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        color: #6b7280;
        font-weight: 600;
    }
    .file-input-label:hover {
        background: #f3f4f6;
        border-color: #7c3aed;
        color: #7c3aed;
    }
    input[type="file"] {
        position: absolute;
        left: -9999px;
    }
    .file-name {
        margin-top: 8px;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    /* Error Messages */
    .text-error { 
        color: #dc2626; 
        font-size: 0.875rem; 
        margin-top: 6px;
        display: block;
    }
    
    /* Info Box */
    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: start;
    }
    .info-box i {
        color: #3b82f6;
        font-size: 1.25rem;
        margin-top: 2px;
    }
    .info-box-content {
        flex: 1;
    }
    .info-box-title {
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 4px;
        font-size: 0.938rem;
    }
    .info-box-text {
        color: #3b82f6;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    /* Form Actions */
    .form-actions { 
        display: flex; 
        gap: 12px; 
        justify-content: flex-end; 
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }
    .btn { 
        padding: 12px 24px; 
        border-radius: 8px; 
        font-size: 0.938rem; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.2s; 
        border: none;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-submit { 
        background: #7c3aed; 
        color: white; 
    }
    .btn-submit:hover { 
        background: #6d28d9; 
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
    }
    .btn-cancel { 
        background: #f3f4f6; 
        color: #374151; 
    }
    .btn-cancel:hover { 
        background: #e5e7eb; 
    }
    
    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 0.813rem;
        color: #9ca3af;
        margin-top: 4px;
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('blog.index') }}" class="bm-back-btn">
        <div class="bm-back-icon">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>Back to My Blogs</span>
    </a>

    <div class="page-header">
        <h3 class="page-title">Create New Blog</h3>
        <p class="page-subtitle">Share your knowledge and insights with the community</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <div class="info-box-content">
            <div class="info-box-title">Content Review Notice</div>
            <div class="info-box-text">
                Blogs with images or certain words will require admin review before being published. You'll be notified if your blog needs approval.
            </div>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
            @csrf

            <!-- Title -->
            <div class="form-group">
                <label for="blogTitle" class="form-label">
                    Blog Title <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    name="blogTitle" 
                    id="blogTitle" 
                    value="{{ old('blogTitle') }}" 
                    placeholder="Enter an engaging title for your blog"
                    maxlength="255"
                    required>
                <div class="char-counter">
                    <span id="titleCount">0</span>/255 characters
                </div>
                @error('blogTitle')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="categoryID" class="form-label">
                    Category <span class="required">*</span>
                </label>
                <select name="categoryID" id="categoryID" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->categoryID }}" {{ old('categoryID') == $category->categoryID ? 'selected' : '' }}>
                            {{ $category->categoryName }}
                        </option>
                    @endforeach
                </select>
                @error('categoryID')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="blogContent" class="form-label">
                    Content <span class="required">*</span>
                </label>
                <textarea 
                    name="blogContent" 
                    id="blogContent" 
                    placeholder="Write your blog content here... Share your thoughts, experiences, and insights."
                    required>{{ old('blogContent') }}</textarea>
                <div class="char-counter">
                    <span id="contentCount">0</span> characters
                </div>
                @error('blogContent')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label for="blogImg" class="form-label">
                    Featured Image <span style="color: #6b7280; font-weight: 400;">(Optional - requires review)</span>
                </label>
                <div class="file-input-wrapper">
                    <label for="blogImg" class="file-input-label">
                        <i class="bi bi-cloud-upload"></i>
                        <span>Choose an image</span>
                    </label>
                    <input 
                        type="file" 
                        name="blogImg" 
                        id="blogImg" 
                        accept="image/*"
                        onchange="displayFileName(this)">
                </div>
                <div class="file-name" id="fileName"></div>
                <div style="font-size: 0.813rem; color: #6b7280; margin-top: 6px;">
                    Supported formats: JPEG, PNG, JPG, GIF, SVG (Max: 2MB)
                </div>
                @error('blogImg')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('blog.index') }}" class="btn btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-lg"></i>
                    Create Blog
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Character counter for title
document.getElementById('blogTitle').addEventListener('input', function() {
    document.getElementById('titleCount').textContent = this.value.length;
});

// Character counter for content
document.getElementById('blogContent').addEventListener('input', function() {
    document.getElementById('contentCount').textContent = this.value.length;
});

// Display selected file name
function displayFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDiv = document.getElementById('fileName');
    if (fileName) {
        fileNameDiv.innerHTML = `<i class="bi bi-file-image"></i> ${fileName}`;
        fileNameDiv.style.color = '#7c3aed';
        fileNameDiv.style.fontWeight = '600';
    } else {
        fileNameDiv.textContent = '';
    }
}

// Initialize counters on page load
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('blogTitle');
    const contentInput = document.getElementById('blogContent');
    
    if (titleInput.value) {
        document.getElementById('titleCount').textContent = titleInput.value.length;
    }
    if (contentInput.value) {
        document.getElementById('contentCount').textContent = contentInput.value.length;
    }
});
</script>

@endsection

