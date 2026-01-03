@extends('layouts.main')

@section('content')

<style>
    body { 
        background: #fafbfc; 
    }
    
    /* Hero Image Section */
    .blog-hero-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        margin-bottom: 32px;
    }
    
    /* Blog Container */
    .blog-container { 
        max-width: 800px; 
        margin: 0 auto; 
        background: white; 
        border-radius: 16px; 
        border: 1px solid #f3f4f6; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); 
        overflow: hidden;
    }
    
    /* Blog Header */
    .blog-header {
        padding: 40px 48px 32px;
    }
    
    .blog-meta-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .blog-category-tag { 
        font-size: 0.875rem; 
        font-weight: 600; 
        color: #7c3aed; 
        background: #f3e8ff; 
        padding: 6px 14px; 
        border-radius: 20px; 
        display: inline-block;
    }
    
    .reading-time {
        color: #9ca3af;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .blog-title { 
        font-size: 2.5rem; 
        font-weight: 800; 
        color: #111827; 
        margin-bottom: 24px;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    
    .blog-author-section { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
    }
    
    .author-avatar-large { 
        width: 48px; 
        height: 48px; 
        border-radius: 50%; 
        overflow: hidden;
    }
    
    .author-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .author-info { 
        flex: 1;
    }
    
    .author-name { 
        font-weight: 700; 
        color: #111827; 
        font-size: 1rem;
        margin-bottom: 4px;
    }
    
    .blog-date { 
        color: #9ca3af; 
        font-size: 0.875rem;
    }
    
    /* Blog Content - Article Style */
    .blog-content { 
        padding: 0 48px 40px;
        color: #374151; 
        font-size: 1.125rem; 
        line-height: 1.8;
    }
    
    .blog-content p {
        margin-bottom: 1.5em;
    }
    
    .blog-content p:first-child::first-letter {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1;
        float: left;
        margin: 0.1em 0.1em 0 0;
        color: #7c3aed;
    }
    
    /* Blog Actions Bar */
    .blog-actions-bar { 
        padding: 20px 48px; 
        display: flex; 
        align-items: center;
        gap: 16px;
        background: #fafbfc;
        border-top: 1px solid #f3f4f6;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .actions-left {
        display: flex;
        gap: 12px;
        flex: 1;
    }
    
    .actions-right {
        display: flex;
        gap: 8px;
    }
    
    .action-btn { 
        padding: 10px 18px; 
        border-radius: 10px; 
        font-size: 0.938rem; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.2s; 
        border: none; 
        display: flex; 
        align-items: center; 
        gap: 8px;
        position: relative;
        z-index: 10;
    }
    
    .btn-share {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-share:hover {
        background: #e5e7eb;
    }
    
    .btn-report { 
        background: #fee2e2; 
        color: #dc2626; 
    }
    
    .btn-report:hover { 
        background: #fecaca; 
    }
    
    /* Comments Section */
    .comments-section { 
        padding: 40px 48px;
    }
    
    .comments-header { 
        font-size: 1.5rem; 
        font-weight: 700; 
        color: #111827; 
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Add Comment Form */
    .add-comment-form { 
        background: #f9fafb; 
        padding: 20px; 
        border-radius: 12px; 
        margin-bottom: 32px;
        border: 1px solid #f3f4f6;
    }
    
    .comment-textarea { 
        width: 100%; 
        padding: 14px; 
        border: 1px solid #e5e7eb; 
        border-radius: 10px; 
        font-size: 1rem; 
        resize: vertical; 
        min-height: 100px;
        margin-bottom: 12px;
        font-family: inherit;
        background: white;
    }
    
    .comment-textarea:focus { 
        outline: none; 
        border-color: #7c3aed; 
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    
    .btn-submit-comment { 
        padding: 12px 24px; 
        background: #7c3aed; 
        color: white; 
        border: none; 
        border-radius: 10px; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
    }
    
    .btn-submit-comment:hover { 
        background: #6d28d9; 
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    
    /* Comment Item */
    .comment-item { 
        padding: 20px; 
        background: #fafbfc; 
        border-radius: 12px; 
        margin-bottom: 16px;
        border: 1px solid #f3f4f6;
        transition: all 0.2s;
    }
    
    .comment-item:hover {
        border-color: #e5e7eb;
    }
    
    .comment-header { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        margin-bottom: 12px;
    }
    
    .comment-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 50%; 
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .comment-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .comment-author-info {
        flex: 1;
    }
    
    .comment-author { 
        font-weight: 600; 
        color: #111827; 
        font-size: 1rem;
        margin-bottom: 2px;
    }
    
    .comment-date { 
        color: #9ca3af; 
        font-size: 0.875rem;
    }
    
    .comment-text { 
        color: #374151; 
        font-size: 1rem; 
        line-height: 1.6;
        margin-bottom: 12px;
        padding-left: 52px;
    }
    
    .comment-actions {
        display: flex;
        gap: 12px;
        padding-left: 52px;
    }
    
    .btn-comment-action {
        padding: 6px 12px;
        background: transparent;
        color: #9ca3af;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        position: relative;
        z-index: 10;
    }
    
    .btn-comment-action:hover {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .btn-delete-comment {
        color: #9ca3af;
    }
    
    .btn-delete-comment:hover {
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Empty Comments */
    .empty-comments { 
        text-align: center; 
        padding: 60px 20px; 
        color: #9ca3af;
    }
    
    .empty-comments i { 
        font-size: 3rem; 
        margin-bottom: 16px; 
        color: #d1d5db;
    }
    
    .empty-comments p { 
        font-size: 1rem;
    }
    
    /* Alert */
    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        border: 1px solid #fde68a;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.938rem;
    }
    
    .alert-warning i {
        font-size: 1.25rem;
        flex-shrink: 0;
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
    
    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 24px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
        font-size: 0.938rem;
    }
    
    .form-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 1rem;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
        margin-bottom: 20px;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    
    .modal-footer {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn-modal {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        font-size: 1rem;
    }
    
    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-cancel:hover {
        background: #e5e7eb;
    }
    
    .btn-submit-modal {
        background: #dc2626;
        color: white;
    }
    
    .btn-submit-modal:hover {
        background: #b91c1c;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .blog-header,
        .blog-content,
        .blog-actions-bar,
        .comments-section {
            padding-left: 24px;
            padding-right: 24px;
        }
        
        .blog-title {
            font-size: 2rem;
        }
        
        .blog-content {
            font-size: 1.063rem;
        }
        
        .comment-text,
        .comment-actions {
            padding-left: 0;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('blog.feed') }}" class="bm-back-btn" style="margin-bottom: 24px;">
        <div class="bm-back-icon"><i class="bi bi-arrow-left"></i></div>
        <span>Back to Feed</span>
    </a>

    @if($blog->status === 'pending' && $blog->userID === auth()->id())
        <div class="alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>This blog is pending admin review and is not visible to other users.</span>
        </div>
    @endif

    <div class="blog-container">
        <!-- Hero Image -->
        @if($blog->blogImg)
            @if($blog->blogImg === 'blog-default.jpg')
                <img src="{{ asset('img/blog-default.jpg') }}" alt="{{ $blog->blogTitle }}" class="blog-hero-image">
            @else
                <img src="{{ asset('storage/'.$blog->blogImg) }}" alt="{{ $blog->blogTitle }}" class="blog-hero-image">
            @endif
        @endif

        <!-- Blog Header -->
        <div class="blog-header">
            <div class="blog-meta-top">
                <span class="blog-category-tag">{{ $blog->category->categoryName }}</span>
                <span class="reading-time">
                    <i class="bi bi-clock"></i>
                    {{ ceil(str_word_count($blog->blogContent) / 200) }} min read
                </span>
            </div>
            
            <h1 class="blog-title">{{ $blog->blogTitle }}</h1>
            
            <div class="blog-author-section">
                <div class="author-avatar-large">
                    <a href='{{ route('study-partner.social-profile.show', ['user' => $blog->user->id]) }}'>
                        <img 
                            src="{{ $blog->user->userInfo->profile_image ? asset('storage/' . $blog->user->userInfo->profile_image) : asset('img/default-profile.png') }}"
                            alt="{{ $blog->user->name }}"
                        >
                    </a>
                </div>
                <div class="author-info">
                    <div class="author-name">{{ $blog->user->name }}</div>
                    <div class="blog-date">{{ $blog->posted_at->format('F j, Y') }} • {{ $blog->posted_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Blog Content -->
        <div class="blog-content">
            {!! nl2br(e($blog->blogContent)) !!}
        </div>

        <!-- Blog Actions Bar -->
        <div class="blog-actions-bar">
            <div class="actions-left">
                <x-like-button :blog="$blog" :showText="true" />
                
                <button type="button" class="action-btn btn-share" onclick="sharePost()">
                    <i class="bi bi-share"></i>
                    Share
                </button>
            </div>
            
            <div class="actions-right">
                <button type="button" class="action-btn btn-report" onclick="openReportModal({{ $blog->blogID }}, 'blog')">
                    <i class="bi bi-flag"></i>
                    Report
                </button>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <div class="comments-header">
                <i class="bi bi-chat-left-text-fill"></i>
                {{ $blog->comments->count() }} {{ Str::plural('Comment', $blog->comments->count()) }}
            </div>

            <!-- Add Comment Form -->
            <div class="add-comment-form">
                <form action="{{ route('blog.comments.store', $blog->blogID) }}" method="POST">
                    @csrf
                    <textarea 
                        name="commentText" 
                        class="comment-textarea" 
                        placeholder="Share your thoughts..." 
                        required
                    ></textarea>
                    <button type="submit" class="btn-submit-comment">
                        <i class="bi bi-send-fill"></i>
                        Post Comment
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            @forelse($blog->comments as $comment)
                <div class="comment-item">
                    <div class="comment-header">
                        <div class="comment-avatar">
                            <img 
                                src="{{ $blog->user->userInfo->profile_image ? asset('storage/' . $blog->user->userInfo->profile_image) : asset('img/default-profile.png') }}"
                                alt="{{ $comment->user->name }}"
                            >
                        </div>
                        <div class="comment-author-info">
                            <div class="comment-author">{{ $comment->user->name }}</div>
                            <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="comment-text">{{ $comment->commentText }}</div>
                    <div class="comment-actions">
                        @if($comment->userID === auth()->id())
                            <!-- Delete Own Comment -->
                            <form action="{{ route('blog.comments.destroy', [$blog->blogID, $comment->commentID]) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this comment?');"
                                  style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-comment-action btn-delete-comment">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </button>
                            </form>
                        @endif
                        
                        <!-- Report Comment (for everyone) -->
                        <button type="button" class="btn-comment-action" onclick="openReportModal(null, 'comment', {{ $comment->commentID }})">
                            <i class="bi bi-flag"></i>
                            Report
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-comments">
                    <i class="bi bi-chat-dots"></i>
                    <p>No comments yet. Be the first to share your thoughts!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Report Modal -->
<div id="reportModal" class="report-modal">
    <div class="modal-content">
        <h3 class="modal-title">Report Content</h3>
        
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <input type="hidden" id="reportBlogID" name="blogID">
            <input type="hidden" id="reportCommentID" name="commentID">
            
            <label class="form-label">Why are you reporting this?</label>
            <textarea 
                name="report_reason" 
                class="form-textarea" 
                placeholder="Please describe the issue with this content..."
                required
            ></textarea>
            
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeReportModal()">
                    Cancel
                </button>
                <button type="submit" class="btn-modal btn-submit-modal">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Define functions in global scope BEFORE they're called
    window.openReportModal = function(blogId, type, commentId = null) {
        console.log('openReportModal called:', { blogId, type, commentId });
        
        const modal = document.getElementById('reportModal');
        if (!modal) {
            console.error('Report modal not found!');
            return;
        }
        
        if (type === 'blog') {
            document.getElementById('reportBlogID').value = blogId;
            document.getElementById('reportCommentID').value = '';
        } else {
            document.getElementById('reportCommentID').value = commentId;
            document.getElementById('reportBlogID').value = '';
        }
        modal.style.display = 'flex';
        console.log('Modal opened');
    };

    window.closeReportModal = function() {
        console.log('closeReportModal called');
        const modal = document.getElementById('reportModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    window.sharePost = function() {
        console.log('sharePost called');
        
        const blogTitle = @json($blog->blogTitle);
        const blogText = @json(Str::limit(strip_tags($blog->blogContent), 100));
        
        if (navigator.share) {
            navigator.share({
                title: blogTitle,
                text: blogText,
                url: window.location.href
            }).then(() => {
                console.log('Share successful');
            }).catch(err => {
                console.log('Error sharing:', err);
            });
        } else {
            // Fallback: Copy link to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
                console.log('Link copied to clipboard');
            }).catch(err => {
                console.error('Failed to copy link:', err);
                alert('Failed to copy link. Please copy manually: ' + window.location.href);
            });
        }
    };

    // Close modal when clicking outside - use addEventListener when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up event listeners');
        
        const reportModal = document.getElementById('reportModal');
        if (reportModal) {
            reportModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeReportModal();
                }
            });
            console.log('Report modal event listener attached');
        } else {
            console.error('Report modal element not found in DOM');
        }
    });

    console.log('All functions defined successfully');
</script>

@endsection