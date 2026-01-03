@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    .detail-container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Main Card */
    .note-detail-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
    }

    /* Header Section */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .badge-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .detail-meta {
        display: flex;
        gap: 20px;
        font-size: 0.813rem;
        color: #6b7280;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .meta-item i {
        font-size: 0.938rem;
    }

    /* Description & Content Sections */
    .content-section {
        margin-bottom: 24px;
        padding: 16px;
        background: #f9fafb;
        border-radius: 8px;
    }

    .content-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .content-label i {
        font-size: 0.875rem;
    }

    .content-text {
        font-size: 0.875rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
    }

    /* Resources Section */
    .resources-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .resources-title {
        font-size: 1.125rem;
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

    /* Resource Tabs */
    .resource-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
        border-bottom: 2px solid #f3f4f6;
    }

    .resource-tab {
        padding: 10px 16px;
        border: none;
        background: none;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }

    .resource-tab:hover {
        color: #374151;
    }

    .resource-tab.active {
        color: var(--bm-purple);
        border-bottom-color: var(--bm-purple);
    }

    /* Resource List */
    .resource-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .resource-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
    }

    .resource-item:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .resource-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .resource-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
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
        font-size: 0.875rem;
        color: #111827;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .resource-meta {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .resource-actions {
        display: flex;
        gap: 6px;
    }

    .resource-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #f9fafb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        text-decoration: none;
    }

    .resource-btn:hover {
        background: #f3f4f6;
    }

    .resource-btn.download:hover {
        background: #dbeafe;
        color: #2563eb;
    }

    .resource-btn.delete:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        background: #f9fafb;
        border-radius: 10px;
        border: 1px dashed #d1d5db;
    }

    .empty-icon {
        font-size: 2.5rem;
        color: #d1d5db;
        margin-bottom: 12px;
    }

    .empty-title {
        font-size: 0.938rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .empty-text {
        font-size: 0.813rem;
        color: #9ca3af;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert i {
        font-size: 1.125rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
    }

    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-edit {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .btn-edit:hover {
        background: var(--bm-purple);
        color: white;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
    }
</style>

<div class="container py-4">
    <div class="detail-container">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('notes.index') }}" class="bm-back-btn">
            <div class="bm-back-icon">
                <i class="bi bi-arrow-left"></i>
            </div>
            <span>Back to Notes</span>
        </a>

        <!-- Main Card -->
        <div class="note-detail-card">
            
            <!-- Header -->
            <div class="detail-header">
                <div style="flex: 1;">
                    <h1 class="detail-title">{{ $note->title }}</h1>
                    
                    <!-- Tags -->
                    @if($note->tags)
                        <div class="badge-group">
                            @foreach($note->getTagsArray() as $tag)
                                <span class="badge">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Meta Info -->
                    <div class="detail-meta">
                        <div class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span>Created {{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-paperclip"></i>
                            <span>{{ $note->getResourcesCount() }} resource(s)</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">
                        <span>Edit</span>
                    </a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" 
                          onsubmit="return confirm('Delete this note and all its resources? This action cannot be undone.');" 
                          style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <span>Delete</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Description -->
            @if($note->description)
                <div class="content-section">
                    <div class="content-label">
                        <i class="bi bi-text-paragraph"></i>
                        Description
                    </div>
                    <p class="content-text">{{ $note->description }}</p>
                </div>
            @endif

            <!-- Content -->
            @if($note->content)
                <div class="content-section">
                    <div class="content-label">
                        <i class="bi bi-file-text"></i>
                        Note Content
                    </div>
                    <p class="content-text">{{ $note->content }}</p>
                </div>
            @endif

            <!-- Resources Section -->
            <div class="resources-header">
                <h2 class="resources-title">
                    Resources
                    <span class="resource-count-badge">{{ $note->resources->count() }}</span>
                </h2>
            </div>

            @if($note->hasResources())
                <!-- Resource Tabs -->
                <div class="resource-tabs">
                    <button class="resource-tab active" onclick="showTab('all')">
                        All ({{ $note->resources->count() }})
                    </button>
                    <button class="resource-tab" onclick="showTab('files')">
                        Files ({{ $files->count() }})
                    </button>
                    <button class="resource-tab" onclick="showTab('links')">
                        Links ({{ $links->count() }})
                    </button>
                </div>

                <!-- All Resources -->
                <div class="resource-list" id="tab-all">
                    @foreach($note->resources as $resource)
                        @php
                            $isFile = $resource->resource_type === 'file';
                            $extension = $isFile ? strtolower(pathinfo($resource->resource_file_path, PATHINFO_EXTENSION)) : null;
                            $isPdf = $extension === 'pdf';
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        <div class="resource-item">
                            <div class="resource-left">
                                <!-- Icon -->
                                <div class="resource-icon {{ $isPdf ? 'pdf' : ($isImage ? 'image' : 'link') }}">
                                    @if($isPdf)
                                        <i class="bi bi-file-pdf"></i>
                                    @elseif($isImage)
                                        <i class="bi bi-file-image"></i>
                                    @else
                                        <i class="bi bi-link-45deg"></i>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="resource-info">
                                    <div class="resource-name">
                                        {{ $resource->resource_name ?? ($isFile ? basename($resource->resource_file_path) : $resource->resource_link) }}
                                    </div>
                                    <div class="resource-meta">
                                        @if($isFile)
                                            {{ strtoupper($extension) }}
                                            @if(Storage::disk('public')->exists($resource->resource_file_path))
                                                • {{ number_format(Storage::disk('public')->size($resource->resource_file_path) / 1024, 2) }} KB
                                            @endif
                                        @else
                                            Link • {{ Str::limit($resource->resource_link, 50) }}
                                        @endif
                                        • {{ $resource->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="resource-actions">
                                @if($isFile)
                                    <a href="{{ route('notes.resources.view', $resource->id) }}" 
                                       target="_blank"
                                       class="resource-btn download" 
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('notes.resources.download', $resource->id) }}" 
                                       class="resource-btn download" 
                                       title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                @else
                                    <a href="{{ $resource->resource_link }}" 
                                       target="_blank" 
                                       class="resource-btn download" 
                                       title="Open link">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('notes.resources.destroy', $resource->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Delete this resource?');" 
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="resource-btn delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Files Only -->
                <div class="resource-list" id="tab-files" style="display: none;">
                    @forelse($files as $resource)
                        @php
                            $extension = strtolower(pathinfo($resource->resource_file_path, PATHINFO_EXTENSION));
                            $isPdf = $extension === 'pdf';
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        <div class="resource-item">
                            <div class="resource-left">
                                <div class="resource-icon {{ $isPdf ? 'pdf' : 'image' }}">
                                    <i class="bi bi-file-{{ $isPdf ? 'pdf' : 'image' }}"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-name">
                                        {{ $resource->resource_name ?? basename($resource->resource_file_path) }}
                                    </div>
                                    <div class="resource-meta">
                                        {{ strtoupper($extension) }}
                                        @if(Storage::disk('public')->exists($resource->resource_file_path))
                                            • {{ number_format(Storage::disk('public')->size($resource->resource_file_path) / 1024, 2) }} KB
                                        @endif
                                        • {{ $resource->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="resource-actions">
                                <a href="{{ route('notes.resources.view', $resource->id) }}" 
                                   target="_blank"
                                   class="resource-btn download" 
                                   title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('notes.resources.download', $resource->id) }}" 
                                   class="resource-btn download" 
                                   title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('notes.resources.destroy', $resource->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Delete this file?');" 
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="resource-btn delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-file-earmark"></i></div>
                            <div class="empty-title">No files yet</div>
                            <div class="empty-text">Upload PDFs or images in the edit page</div>
                        </div>
                    @endforelse
                </div>

                <!-- Links Only -->
                <div class="resource-list" id="tab-links" style="display: none;">
                    @forelse($links as $resource)
                        <div class="resource-item">
                            <div class="resource-left">
                                <div class="resource-icon link">
                                    <i class="bi bi-link-45deg"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-name">
                                        {{ $resource->resource_name ?? 'Untitled Link' }}
                                    </div>
                                    <div class="resource-meta">
                                        Link • {{ Str::limit($resource->resource_link, 50) }} • {{ $resource->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="resource-actions">
                                <a href="{{ $resource->resource_link }}" 
                                   target="_blank" 
                                   class="resource-btn download" 
                                   title="Open link">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <form action="{{ route('notes.resources.destroy', $resource->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Delete this link?');" 
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="resource-btn delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-link-45deg"></i></div>
                            <div class="empty-title">No links yet</div>
                            <div class="empty-text">Add useful links in the edit page</div>
                        </div>
                    @endforelse
                </div>

            @else
                <!-- No Resources -->
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-paperclip"></i></div>
                    <div class="empty-title">No resources yet</div>
                    <div class="empty-text">Add files and links to enhance your note</div>
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn-create" style="margin-top: 16px;">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Resources</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tabs
        document.getElementById('tab-all').style.display = 'none';
        document.getElementById('tab-files').style.display = 'none';
        document.getElementById('tab-links').style.display = 'none';

        // Remove active class from all tabs
        document.querySelectorAll('.resource-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Show selected tab
        document.getElementById('tab-' + tabName).style.display = 'flex';

        // Add active class to clicked tab
        event.target.classList.add('active');
    }
</script>

@endsection