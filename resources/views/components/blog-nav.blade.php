@props(['active' => ''])

<style>
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
    .nav-tab.new-post {
        background: #7c3aed;
        color: white;
        margin-left: auto;
    }
    .nav-tab.new-post:hover {
        background: #6d28d9;
        color: white;
    }
</style>

<div class="blog-nav-tabs">
    <a href="{{ route('blog.feed') }}" class="nav-tab {{ $active === 'feed' ? 'active' : '' }}">
        <i class="bi bi-grid-3x3-gap"></i>
        <span>Explore</span>
    </a>
    <a href="{{ route('blog.index') }}" class="nav-tab {{ $active === 'my-blogs' ? 'active' : '' }}">
        <i class="bi bi-journal-text"></i>
        <span>My Blogs</span>
    </a>
    <a href="{{ route('blog.liked') }}" class="nav-tab {{ $active === 'liked' ? 'active' : '' }}">
        <i class="bi bi-heart"></i>
        <span>Liked</span>
    </a>
    <a href="{{ route('blog.create') }}" class="btn-create  {{ $active === 'create' ? 'active' : '' }}" style="margin-left: auto;">
        <i class="bi bi-plus-lg"></i>
        <span>New Post</span>
    </a>
</div> 