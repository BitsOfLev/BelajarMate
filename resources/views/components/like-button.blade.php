@props(['blog', 'showText' => false])

<form action="{{ route('blog.like', $blog->blogID) }}" method="POST" style="flex: 1;">
    @csrf
    <button type="submit" 
        class="like-btn {{ $blog->isLikedBy(auth()->id()) ? 'liked' : '' }}"
        title="{{ $blog->isLikedBy(auth()->id()) ? 'Unlike' : 'Like' }}">
        <i class="bi {{ $blog->isLikedBy(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
        @if($showText)
            <span class="like-count">{{ $blog->likes->count() }} {{ Str::plural('Like', $blog->likes->count()) }}</span>
        @else
            <span class="like-count">{{ $blog->likes->count() }}</span>
        @endif
    </button>
</form>

<style>
    .like-btn {
        background: #f3f4f6;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s ease;
        color: #6b7280;
        position: relative;
        width: 100%;
    }
    
    .like-btn:hover {
        background: #fee2e2;
        transform: scale(1.05);
    }
    
    .like-btn i {
        font-size: 1.125rem;
        transition: all 0.2s ease;
    }
    
    .like-btn:not(.liked) i {
        color: #6b7280;
    }
    
    .like-btn.liked i {
        color: #ef4444;
        animation: heartbeat 0.3s ease;
    }
    
    .like-btn.liked {
        color: #ef4444;
        background: #fee2e2;
    }
    
    .like-btn:active {
        transform: scale(0.95);
    }
    
    .like-count {
        font-size: 0.875rem;
        min-width: 20px;
        text-align: left;
    }
    
    /* Tooltip */
    .like-btn::before {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        background: #111827;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 10;
    }
    
    .like-btn::after {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-2px);
        border: 5px solid transparent;
        border-top-color: #111827;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    
    .like-btn:hover::before,
    .like-btn:hover::after {
        opacity: 1;
    }
    
    @keyframes heartbeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1.1); }
        75% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>