@extends('layouts.main')

@section('title', 'Notifications')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-semibold mb-0" style="color:#8c52ff;">
            <i class='bx bx-bell me-2'></i>Notifications
        </h4>
        
        {{-- Button Group --}}
        <div class="d-flex gap-2">
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.mark-all-read') }}" 
                class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class='bx bx-check-double me-1'></i>
                    Mark all as read
                </a>
            @endif
            
            @if(auth()->user()->readNotifications->count() > 0)
                <button type="button" 
                        class="btn btn-sm btn-outline-danger rounded-pill"
                        onclick="confirmClearRead()">
                    <i class='bx bx-trash me-1'></i>
                    Clear read
                </button>
            @endif
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="alert alert-info rounded-3 mb-4 d-flex align-items-start border-0" style="background-color: #e0f2fe;">
        <i class='bx bx-info-circle fs-5 me-2' style="color: #0369a1; margin-top: 2px;"></i>
        <div class="small" style="color: #0c4a6e;">
            <strong>About your notifications:</strong>
            Read notifications are automatically deleted after 30 days to keep things organized. 
            Unread notifications are kept until you read them.
        </div>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        @php
                            $data = $notification->data;
                            // Determine action URL
                            $actionUrl = $data['action_url'] ?? '#';
                            if (!isset($data['action_url']) && isset($data['blog_id'])) {
                                $actionUrl = route('blog.show', $data['blog_id']);
                            }
                        @endphp 
                        <a href="{{ $actionUrl }}" 
                        class="notification-list-item {{ $notification->read_at ? '' : 'unread' }}"
                        onclick="markNotificationAsRead('{{ $notification->id }}')">
                            <div class="d-flex align-items-start p-3 border-bottom">
                                <div class="notification-list-icon me-3">
                                    <i class="{{ $data['icon'] ?? 'bx-bell' }} {{ $data['color'] ?? '' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        {{-- Show title if exists, otherwise show message as title --}}
                                        @if(isset($data['title']))
                                            <h6 class="mb-0 fw-semibold">{{ $data['title'] }}</h6>
                                        @else
                                            <h6 class="mb-0 fw-semibold">{{ Str::limit($data['message'], 100) }}</h6>
                                        @endif
                                        @if(!$notification->read_at)
                                            <span class="badge bg-primary rounded-circle p-1" style="width: 8px; height: 8px;"></span>
                                        @endif
                                    </div>
                                    {{-- Show full message if title exists, otherwise skip (already shown above) --}}
                                    @if(isset($data['title']))
                                        <p class="mb-1 text-muted small">{{ $data['message'] }}</p>
                                    @endif
                                    <small class="text-muted">
                                        <i class='bx bx-time-five'></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5">
                            <i class='bx bx-bell-off' style="font-size: 4rem; color: #d1d5db;"></i>
                            <p class="text-muted mt-3 mb-0">No notifications yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .notification-list-item {
        display: block;
        text-decoration: none;
        color: inherit;
        transition: background-color 0.2s;
    }

    .notification-list-item:hover {
        background-color: #f9fafb;
    }

    .notification-list-item.unread {
        background-color: #f0f4ff;
    }

    .notification-list-item:last-child .border-bottom {
        border-bottom: none !important;
    }

    .notification-list-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #8c52ff 0%, #a78bfa 100%);
        border-radius: 12px;
        flex-shrink: 0;
    }

    .notification-list-icon i {
        font-size: 1.5rem;
        color: white;
    }
</style>

<script>
    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });
    }

    function confirmClearRead() {
        if (confirm('Are you sure you want to delete all read notifications? This cannot be undone.')) {
            window.location.href = "{{ route('notifications.clear-read') }}";
        }
    }
</script>
@endsection