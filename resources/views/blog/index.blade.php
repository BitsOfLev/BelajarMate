@extends('layouts.main')

@section('content')

<style>
    body { background: #fafbfc; }
    
    .blog-page-header {
        margin-bottom: 32px;
    }
    
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
    }
    
    /* .empty-action {
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
    } */
    
    .empty-action:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    
    @media (max-width: 768px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container py-4">
    <div class="blog-page-header">
        <h1 class="page-title">My Blogs</h1>
        <p class="page-subtitle">Manage your blog posts and track their status</p>
    </div>

    <!-- Navigation Tabs -->
    <x-blog-nav active="my-blogs" />

    @if($blogs->isEmpty())
        <div class="blog-empty-state">
            <div class="empty-icon">
                <i class="bi bi-journal-text"></i>
            </div>
            <h2 class="empty-title">No blogs yet</h2>
            <p class="empty-text">Start sharing your thoughts by creating your first blog post</p>
            <a href="{{ route('blog.create') }}" class="btn-create">
                <i class="bi bi-plus-lg"></i>
                Create Your First Blog
            </a>
        </div>
    @else
        <div class="blog-grid">
            @foreach($blogs as $blog)
                <x-blog-card 
                    :blog="$blog" 
                    :showActions="false" 
                    :showStatus="true" 
                    :showMyBlogActions="true" 
                />
            @endforeach
        </div>
    @endif
</div>

@endsection


