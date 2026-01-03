@props(['blog', 'showActions' => true, 'showStatus' => false, 'showMyBlogActions' => false])

<div class="blog-card" onclick="window.location='{{ route('blog.show', $blog->blogID) }}'">
    <!-- Blog Image -->
    <div class="blog-card-image">
        @if($blog->blogImg)
            @if($blog->blogImg === 'blog-default.jpg')
                <img src="{{ asset('img/blog-default.jpg') }}" alt="{{ $blog->blogTitle }}">
            @else
                <img src="{{ asset('storage/'.$blog->blogImg) }}" alt="{{ $blog->blogTitle }}">
            @endif
        @else
            <img src="{{ asset('img/blog-default.jpg') }}" alt="{{ $blog->blogTitle }}">
        @endif
        
        <!-- Status Badge (only for my-blogs page) -->
        @if($showStatus)
            <div class="blog-status-badge status-{{ $blog->status }}">
                @if($blog->status === 'approved')
                    <i class="bi bi-check-circle-fill"></i> Published
                @elseif($blog->status === 'pending')
                    <i class="bi bi-clock-fill"></i> Pending
                @else
                    <i class="bi bi-x-circle-fill"></i> Rejected
                @endif
            </div>
        @endif
    </div>
    
    <!-- Blog Content -->
    <div class="blog-card-content">
        <!-- Category Tag -->
        <span class="blog-card-category">{{ $blog->category->categoryName }}</span>
        
        <!-- Title -->
        <h3 class="blog-card-title">{{ $blog->blogTitle }}</h3>
        
        <!-- Snippet -->
        <p class="blog-card-snippet">{{ Str::limit(strip_tags($blog->blogContent), 100) }}</p>
        
        <!-- Author & Meta -->
        <div class="blog-card-meta">
            <div class="blog-card-author">
                <img 
                    src="{{ $blog->user->userInfo->profile_image ? asset('storage/' . $blog->user->userInfo->profile_image) : asset('img/default-profile.png') }}"
                    alt="{{ $blog->user->name }}"
                    class="author-avatar"
                >
                <span class="author-name">{{ $blog->user->name }}</span>
            </div>
            
            <span class="blog-card-divider">•</span>
            <span class="blog-card-date">{{ $blog->posted_at->format('M j') }}</span>
        </div>
    </div>
    
    <!-- Card Footer with Stats -->
    <div class="blog-card-footer">
        <div class="blog-card-stats">
            <span class="stat-item">
                <i class="bi bi-heart{{ $blog->likes->contains('userID', auth()->id()) ? '-fill' : '' }}"></i>
                {{ $blog->likes->count() }}
            </span>
            <span class="stat-item">
                <i class="bi bi-chat-left"></i>
                {{ $blog->comments->count() }}
            </span>
        </div>
        
        @if($showActions)
            <div class="blog-card-actions" onclick="event.stopPropagation()">
                <!-- Like Button (using existing component) -->
                <div class="action-like-wrapper">
                    <x-like-button :blog="$blog" />
                </div>
                
                <!-- Report Button -->
                <button class="action-btn action-report" onclick="openReportModal({{ $blog->blogID }}, 'blog')" title="Report">
                    <i class="bi bi-flag"></i>
                </button>
            </div>
        @endif
    </div>
    
    <!-- My Blog Actions (Edit/Delete) -->
    @if($showMyBlogActions)
        <div class="my-blog-actions" onclick="event.stopPropagation()">
            <a href="{{ route('blog.show', $blog->blogID) }}" class="my-blog-btn btn-view">
                <i class="bi bi-eye"></i>
                View
            </a>
            
            <a href="{{ route('blog.edit', $blog->blogID) }}" class="my-blog-btn btn-edit">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>
            
            <form action="{{ route('blog.destroy', $blog->blogID) }}" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this blog?');" 
                  style="flex: 1; margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="my-blog-btn btn-delete" style="width: 100%;">
                    <i class="bi bi-trash"></i>
                    Delete
                </button>
            </form>
        </div>
    @endif
    
    <!-- Flag Reason Alert (for rejected blogs) -->
    @if($showStatus && $blog->flag_reason)
        <div class="flag-reason-alert" onclick="event.stopPropagation()">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ $blog->flag_reason }}</span>
        </div>
    @endif
</div>

<style>
    /* Blog Card Container */
    .blog-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f3f4f6;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: #e5e7eb;
    }

    /* Image Section */
    .blog-card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog-card:hover .blog-card-image img {
        transform: scale(1.05);
    }

    /* Status Badge */
    .blog-status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .status-pending {
        background: rgba(251, 191, 36, 0.9);
        color: #78350f;
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.9);
        color: white;
    }

    /* Content Section */
    .blog-card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-card-category {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #7c3aed;
        background: #f3e8ff;
        padding: 4px 12px;
        border-radius: 12px;
        margin-bottom: 12px;
        width: fit-content;
    }

    .blog-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 12px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-card-snippet {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.6;
        margin: 0 0 16px 0;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta Section */
    .blog-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.813rem;
        color: #9ca3af;
    }

    .blog-card-author {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .author-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
    }

    .author-name {
        font-weight: 600;
        color: #374151;
    }

    .blog-card-divider {
        color: #d1d5db;
    }

    .blog-card-date {
        color: #9ca3af;
    }

    /* Footer Section */
    .blog-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        background: #fafbfc;
        border-top: 1px solid #f3f4f6;
    }

    .blog-card-stats {
        display: flex;
        gap: 16px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .stat-item i {
        font-size: 1rem;
    }

    .stat-item i.bi-heart-fill {
        color: #ef4444;
    }

    /* Card Actions */
    .blog-card-actions {
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .blog-card:hover .blog-card-actions {
        opacity: 1;
    }

    /* Wrapper for like button component */
    .action-like-wrapper {
        flex: 0 0 auto;
    }

    .action-like-wrapper form {
        margin: 0;
    }

    .action-like-wrapper .like-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        padding: 0;
        min-width: unset;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-like-wrapper .like-btn:hover {
        background: #fee2e2;
    }

    .action-like-wrapper .like-btn.liked {
        background: #fee2e2;
    }

    .action-like-wrapper .like-count {
        display: none; /* Hide count in card actions */
    }

    .action-like-wrapper .like-btn i {
        margin: 0;
        font-size: 1rem;
    }

    /* Tooltip styles for like button in card */
    .action-like-wrapper .like-btn::before,
    .action-like-wrapper .like-btn::after {
        display: none; /* Disable tooltip in card */
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: white;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .action-btn:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .action-btn.action-report:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* My Blog Actions Section */
    .my-blog-actions {
        padding: 12px 20px;
        background: #fafbfc;
        border-top: 1px solid #f3f4f6;
        display: flex;
        gap: 8px;
    }

    .my-blog-btn {
        flex: 1;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .my-blog-btn.btn-view {
        background: #f3f4f6;
        color: #374151;
    }

    .my-blog-btn.btn-view:hover {
        background: #e5e7eb;
    }

    .my-blog-btn.btn-edit {
        background: #eff6ff;
        color: #3b82f6;
    }

    .my-blog-btn.btn-edit:hover {
        background: #dbeafe;
    }

    .my-blog-btn.btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .my-blog-btn.btn-delete:hover {
        background: #fecaca;
    }

    /* Flag Reason Alert */
    .flag-reason-alert {
        background: #fef3c7;
        border-top: 1px solid #fde68a;
        color: #92400e;
        padding: 12px 20px;
        font-size: 0.875rem;
        display: flex;
        align-items: start;
        gap: 10px;
        line-height: 1.5;
    }

    .flag-reason-alert i {
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .blog-card-image {
            height: 180px;
        }
        
        .blog-card-title {
            font-size: 1rem;
        }
        
        .blog-card-snippet {
            font-size: 0.813rem;
        }
        
        .blog-card-actions {
            opacity: 1; /* Always show on mobile */
        }
    }
</style>