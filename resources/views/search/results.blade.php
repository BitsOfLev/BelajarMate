@extends('layouts.main')

@section('title', 'Edit Profile')

@section('content')
<div class="search-results-container">

    <h2 class="search-results-title">Search Results for "{{ $query }}"</h2>

    <!-- Blogs Section -->
    <section class="search-section">
        <h3 class="search-section-title">Blogs</h3>
        <div class="search-items">
            @forelse($blogs as $blog)
                <a href="{{ route('blog.show', $blog) }}" class="search-item">
                    <div class="search-item-content">
                        <p class="search-item-title">{{ $blog->blogTitle }}</p>
                        <small class="search-item-meta">
                            Posted {{ $blog->created_at->diffForHumans() }} by {{ $blog->user->name }}
                        </small>
                        <p class="search-item-snippet">{{ Str::limit(strip_tags($blog->blogContent), 80) }}</p>
                    </div>
                </a>
            @empty
                <p class="search-empty">No blogs found.</p>
            @endforelse
        </div>
    </section>

    <!-- Notes Section -->
    <section class="search-section">
        <h3 class="search-section-title">Notes</h3>
        <div class="search-items">
            @forelse($notes as $note)
                <a href="{{ route('notes.show', $note) }}" class="search-item">
                    <div class="search-item-content">
                        <p class="search-item-title">{{ $note->title }}</p>
                        <small class="search-item-meta">
                            Created {{ $note->created_at->diffForHumans() }}
                        </small>
                        <p class="search-item-snippet">{{ Str::limit(strip_tags($note->content), 80) }}</p>
                    </div>
                </a>
            @empty
                <p class="search-empty">No notes found.</p>
            @endforelse
        </div>
    </section>

    <!-- Planner Section -->
    <section class="search-section">
        <h3 class="search-section-title">Study Planner</h3>
        <div class="search-items">
            @forelse($study_planner as $planner)
                <a href="{{ route('study-planner.show', $planner) }}" class="search-item">
                    <div class="search-item-content">
                        <p class="search-item-title">{{ $planner->studyPlanName}}</p>
                        <small class="search-item-meta">
                            Created {{ $planner->created_at->diffForHumans() }}
                        </small>
                        <p class="search-item-snippet">{{ Str::limit(strip_tags($planner->description), 80) }}</p>
                    </div>
                </a>
            @empty
                <p class="search-empty">No planner found.</p>
            @endforelse
        </div>
    </section>
</div>

<style>
    /* Container */
    .search-results-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: sans-serif;
    }

    /* Section Titles */
    .search-results-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .search-section {
        margin-bottom: 2rem;
    }

    .search-section-title {
        font-size: 1.25rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 1rem;
    }

    /* Search Items */
    .search-items {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .search-item {
        display: block;
        padding: 0.75rem 1rem;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
    }

    .search-item:hover {
        background-color: #f9f9ff;
        border-color: #8c52ff;
    }

    .search-item-content {
        display: flex;
        flex-direction: column;
    }

    .search-item-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .search-item-meta {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    .search-item-snippet {
        font-size: 0.875rem;
        color: #4b5563;
    }

    /* Empty state */
    .search-empty {
        color: #9ca3af;
        font-style: italic;
        padding: 0.5rem 0;
        text-align: center;
    }
</style>
@endsection
