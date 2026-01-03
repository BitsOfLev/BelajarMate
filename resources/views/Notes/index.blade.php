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

    /* Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .stat-icon.purple { background: #f4efff; color: var(--bm-purple); }
    .stat-icon.blue { background: #dbeafe; color: #2563eb; }
    .stat-icon.green { background: #dcfce7; color: #16a34a; }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }

    /* Control Panel */
    .control-panel {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
    }

    .search-filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr auto;
        gap: 12px;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-size: 0.813rem;
        font-weight: 600;
        color: #6b7280;
    }

    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.875rem;
        background: #f8f9fa;
        color: #1f2937;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
        background: white;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .input-icon .form-control {
        padding-left: 38px;
    }

    .btn-filter {
        background: var(--bm-purple);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-filter:hover {
        background: var(--bm-purple-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .filter-active-badge {
        margin-top: 12px;
        padding: 8px 12px;
        background: #f3f4f6;
        border-radius: 8px;
        font-size: 0.813rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-active-badge a {
        color: var(--bm-purple);
        text-decoration: none;
        font-weight: 600;
    }

    .filter-active-badge a:hover {
        text-decoration: underline;
    }

    /* Notes Grid */
    .notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    /* Note Card */
    .note-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .note-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .note-title {
        font-size: 1.063rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .note-title a {
        color: #111827;
        text-decoration: none;
    }

    .note-title a:hover {
        color: var(--bm-purple);
    }

    .note-description {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 12px;
        flex-grow: 1;
    }

    /* Tags */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }

    .tag-badge {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    /* Note Meta */
    .note-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
        font-size: 0.813rem;
        color: #9ca3af;
        margin-bottom: 12px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Note Actions */
    .note-actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        flex: 1;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.813rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-view {
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
    }

    .btn-view:hover {
        background: var(--bm-purple);
        color: white;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-edit:hover {
        background: #2563eb;
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

    /* Empty State */
    .empty-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
    }

    .empty-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .empty-icon-circle i {
        font-size: 2rem;
        color: #d1d5db;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #9ca3af;
        font-size: 0.938rem;
        margin-bottom: 24px;
        text-align: center;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 32px;
    }

    /* Success Alert */
    .alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
    }

    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        color: #166534;
        cursor: pointer;
        font-size: 1.25rem;
        line-height: 1;
        padding: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-filter-row {
            grid-template-columns: 1fr;
        }

        .notes-grid {
            grid-template-columns: 1fr;
        }

        .stats-bar {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container py-4">

    
    {{-- Page Header --}}
    <div class="page-header">
        <h3 class="page-title">My Notes</h3>
        <p class="page-subtitle">Organize your study materials, resources, and important links</p>
    </div>

    {{-- Stats Bar --}}
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Notes</div>
                    <div class="stat-value">{{ $notes->total() }}</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="bi bi-paperclip"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Resources</div>
                    <div class="stat-value">{{ $notes->sum(fn($n) => $n->getResourcesCount()) }}</div>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Unique Tags</div>
                    <div class="stat-value">{{ count($allTags) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    {{-- Control Panel --}}
    <div class="control-panel">
        <form method="GET" action="{{ route('notes.index') }}">
            <div class="search-filter-row">
                
                {{-- Search Box --}}
                <div class="form-group">
                    <label class="form-label">Search Notes</label>
                    <div class="input-icon">
                        <i class="bi bi-search"></i>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="search" 
                            placeholder="Search in title, description, content..."
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>

                {{-- Tag Filter --}}
                <div class="form-group">
                    <label class="form-label">Filter by Tag</label>
                    <select class="form-select" name="tag">
                        <option value="">All Tags</option>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>
                                {{ $tag }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter & Create Buttons --}}
                <div class="form-group" style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('notes.create') }}" class="btn-create">
                        <i class="bi bi-plus-lg"></i>
                        <span>New Note</span>
                    </a>
                </div>

            </div>

            {{-- Active Filters Badge --}}
            @if(request('search') || request('tag'))
                <div class="filter-active-badge">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        Filters active
                        @if(request('search'))
                            - Search: "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('tag'))
                            - Tag: "<strong>{{ request('tag') }}</strong>"
                        @endif
                    </span>
                    <a href="{{ route('notes.index') }}">Clear all</a>
                </div>
            @endif
        </form>
    </div>

    {{-- Notes Grid or Empty State --}}
    @if($notes->count() > 0)
        <div class="notes-grid">
            @foreach($notes as $note)
                <div class="note-card">
                    
                    {{-- Note Title --}}
                    <h4 class="note-title">
                        <a href="{{ route('notes.show', $note->id) }}">
                            {{ Str::limit($note->title, 60) }}
                        </a>
                    </h4>

                    {{-- Note Description --}}
                    @if($note->description)
                        <p class="note-description">
                            {{ Str::limit($note->description, 120) }}
                        </p>
                    @else
                        <p class="note-description" style="color: #d1d5db; font-style: italic;">
                            No description
                        </p>
                    @endif

                    {{-- Tags --}}
                    @if($note->tags)
                        <div class="tags-container">
                            @foreach($note->getTagsArray() as $tag)
                                <span class="tag-badge">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Meta Info --}}
                    <div class="note-meta">
                        <div class="meta-item">
                            <i class="bi bi-paperclip"></i>
                            <span>{{ $note->getResourcesCount() }} resource(s)</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="note-actions">
                        <a href="{{ route('notes.show', $note->id) }}" class="btn-action btn-view">
                            <i class="bi bi-eye"></i>
                            <span>View</span>
                        </a>
                        <a href="{{ route('notes.edit', $note->id) }}" class="btn-action btn-edit">
                            <i class="bi bi-pencil"></i>
                            <span>Edit</span>
                        </a>
                        <button 
                            type="button" 
                            class="btn-action btn-delete"
                            onclick="deleteNote({{ $note->id }})"
                        >
                            <i class="bi bi-trash"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $notes->links() }}
        </div>

    @else
        {{-- Empty State --}}
        <div class="empty-container">
            <div class="empty-icon-circle">
                <i class="bi bi-journal-text"></i>
            </div>
            <h3 class="empty-title">
                @if(request('search') || request('tag'))
                    No notes found
                @else
                    No notes yet
                @endif
            </h3>
            <p class="empty-text">
                @if(request('search') || request('tag'))
                    Try adjusting your filters or search query
                @else
                    Create your first note to start organizing your study materials
                @endif
            </p>
            <a href="{{ route('notes.create') }}" class="btn-create">
                <i class="bi bi-plus-lg"></i>
                <span>Create Your First Note</span>
            </a>
        </div>
    @endif

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this note? All associated resources will also be deleted. This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteNote(noteId) {
        const form = document.getElementById('deleteForm');
        form.action = `/notes/${noteId}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

@endsection