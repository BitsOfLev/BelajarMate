@extends('layouts.main')

@section('content')

<style>
    body { 
        background: #fafbfc; 
    }
    
    /* Page Header */
    .blog-page-header {
        margin-bottom: 32px;
    }
    
    /* Filter Bar - Cleaner Design */
    .blog-filter-bar {
        background: white;
        padding: 16px 24px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .filter-group {
        display: flex;
        gap: 8px;
    }
    
    .filter-btn {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        background: #f9fafb;
        color: #6b7280;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-btn:hover {
        background: #f3f4f6;
        color: #374151;
    }
    
    .filter-btn.active {
        background: #7c3aed;
        color: white;
        border-color: #7c3aed;
    }
    
    .filter-btn i {
        font-size: 1rem;
    }
    
    .filter-divider {
        width: 1px;
        height: 24px;
        background: #e5e7eb;
        margin: 0 8px;
    }
    
    .filter-select {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid #e5e7eb;
        background: white;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
        min-width: 180px;
    }
    
    .filter-select:hover {
        border-color: #d1d5db;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #7c3aed;
    }
    
    /* Blog Grid */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }
    
    /* Empty State */
    .blog-empty-state {
        background: white;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
        padding: 80px 40px;
        text-align: center;
    }
    
    .empty-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }
    
    .empty-icon i {
        font-size: 2.5rem;
        color: #7c3aed;
    }
    
    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 12px 0;
    }
    
    .empty-text {
        font-size: 1rem;
        color: #6b7280;
        margin: 0 0 24px 0;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .empty-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #7c3aed;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .empty-action:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    
    /* Pagination */
    .blog-pagination {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }
    
    /* Report Modal */
    .report-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .modal-content {
        background: white;
        padding: 32px;
        border-radius: 16px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        margin-bottom: 24px;
    }
    
    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    
    .modal-body {
        margin-bottom: 24px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }
    
    .form-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.938rem;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: #7c3aed;
    }
    
    .modal-footer {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn-modal {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    
    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-cancel:hover {
        background: #e5e7eb;
    }
    
    .btn-submit {
        background: #dc2626;
        color: white;
    }
    
    .btn-submit:hover {
        background: #b91c1c;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
        
        .blog-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .filter-btn {
            flex: 1;
            justify-content: center;
        }
        
        .filter-divider {
            display: none;
        }
        
        .filter-select {
            width: 100%;
        }
    }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="blog-page-header">
        <h1 class="page-title">Community Blog</h1>
        <p class="page-subtitle">Discover insights and stories from fellow students</p>
    </div>

    <!-- Navigation Tabs -->
    <x-blog-nav active="feed" />

    <!-- Filter Bar -->
    <div class="blog-filter-bar">
        <div class="filter-group">
            <a href="{{ route('blog.feed') }}" 
               class="filter-btn {{ !request('filter') && !request('category') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i>
                All Blogs
            </a>
            <a href="{{ route('blog.feed', ['filter' => 'friends']) }}" 
               class="filter-btn {{ request('filter') === 'friends' ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                Friends Only
            </a>
        </div>
        
        <div class="filter-divider"></div>
        
        <form action="{{ route('blog.feed') }}" method="GET" style="flex: 1; display: flex; justify-content: flex-end;">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            
            <select name="category" class="filter-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->categoryID }}" 
                            {{ request('category') == $category->categoryID ? 'selected' : '' }}>
                        {{ $category->categoryName }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Blog Content -->
    @if($blogs->isEmpty())
        <div class="blog-empty-state">
            <div class="empty-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <h2 class="empty-title">No blogs found</h2>
            <p class="empty-text">
                @if(request('filter') === 'friends')
                    Your friends haven't posted any blogs yet. 
                @elseif(request('category'))
                    No blogs found in this category. Try exploring other categories!
                @else
                    Be the first to share your thoughts and inspire the community!
                @endif
            </p>
        </div>
    @else
        <div class="blog-grid">
            @foreach($blogs as $blog)
                <x-blog-card :blog="$blog" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($blogs->hasPages())
            <div class="blog-pagination">
                {{ $blogs->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Report Modal -->
<div id="reportModal" class="report-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Report Content</h3>
        </div>
        
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <input type="hidden" id="reportBlogID" name="blogID">
            <input type="hidden" id="reportCommentID" name="commentID">
            
            <div class="modal-body">
                <label class="form-label">Why are you reporting this?</label>
                <textarea 
                    name="report_reason" 
                    class="form-textarea" 
                    placeholder="Please describe the issue with this content..."
                    required
                ></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeReportModal()">
                    Cancel
                </button>
                <button type="submit" class="btn-modal btn-submit">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Report Modal Functions
    function openReportModal(id, type) {
        if (type === 'blog') {
            document.getElementById('reportBlogID').value = id;
            document.getElementById('reportCommentID').value = '';
        } else {
            document.getElementById('reportCommentID').value = id;
            document.getElementById('reportBlogID').value = '';
        }
        document.getElementById('reportModal').style.display = 'flex';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }

    // Close modal on outside click
    document.getElementById('reportModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReportModal();
        }
    });
</script>

@endsection