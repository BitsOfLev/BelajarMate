<!-- Topbar -->
<header class="topbar">
    <div class="topbar__left">
        <a href="{{ route('home') }}" title="Home">
            <img src="{{ asset('img/logo.png') }}" alt="logo" class="topbar__logo">
        </a>
        <span class="topbar__title">BelajarMate</span>
    </div>

    <div class="topbar__right">
        <form action="{{ route('search') }}" method="GET" class="topbar__search" title="search">
            <input
                type="text"
                name="q"
                placeholder="Search..."
                value="{{ request('q') }}"
            >
            <button type="submit" style="background: none; border: none; cursor: pointer;">
                <i class='bx bx-search'></i>
            </button>
        </form>


        
        <!-- Notification Bell with Dropdown -->
        <div class="topbar__notification-dropdown" title="Notifications">
            <a href="#" class="topbar__notification-trigger" id="notificationBell">
                <i class='bx bxs-bell topbar__icon'></i>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="topbar__notification-badge">
                        {{ Auth::user()->unreadNotifications->count() > 9 ? '9+' : Auth::user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            <!-- Dropdown Menu -->
            <div class="topbar__notification-menu" id="notificationMenu">
               <!-- Header -->
                <div class="notification-header">
                    <h6 class="notification-title">Notifications</h6>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <a href="{{ route('notifications.mark-all-read') }}" class="mark-all-read">
                            Mark all as read
                        </a>
                    @endif
                </div>

                <!-- Notification List -->
                <div class="notification-list">
                    @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                        @php
                            $data = $notification->data;
                            // Determine action URL
                            $actionUrl = $data['action_url'] ?? '#';
                            if (!isset($data['action_url']) && isset($data['blog_id'])) {
                                $actionUrl = route('blog.show', $data['blog_id']);
                            }
                        @endphp
                        <a href="{{ $actionUrl }}" 
                           class="notification-item {{ $notification->read_at ? '' : 'unread' }}"
                           onclick="markAsRead('{{ $notification->id }}')">
                            <div class="notification-icon">
                                <i class="{{ $data['icon'] ?? 'bx-bell' }} {{ $data['color'] ?? '' }}"></i>
                            </div>
                            <div class="notification-content">
                                 <!-- Show title if exists (old notifications), otherwise skip  -->
                                @if(isset($data['title']))
                                    <p class="notification-item-title">{{ $data['title'] }}</p>
                                @endif
                                <p class="notification-item-message">{{ $data['message'] }}</p>
                                <small class="notification-item-time">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->read_at)
                                <span class="unread-dot"></span>
                            @endif
                        </a>
                    @empty
                        <div class="notification-empty">
                            <i class='bx bx-bell-off'></i>
                            <p>No notifications yet</p>
                        </div>
                    @endforelse
                </div>

                <!-- Show All Button -->
                <div class="notification-footer">
                    <a href="{{ route('notifications.index') }}" class="notification-show-all">
                        Show all
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <a href="{{ route('messages.index') }}" title="Message" style="position: relative;">
            <i class='bx bxs-conversation topbar__icon'></i>
            @php
                $unreadCount = Auth::user()->getUnreadMessagesCount();
            @endphp
            @if($unreadCount > 0)
                <span style="position: absolute; top: -4px; right: -4px; background: #dc2626; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.688rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </a>

        <!-- Profile Dropdown -->
        <div class="topbar__profile-dropdown">
            <span class="topbar__profile">
                {{ Auth::user()->name }}
                <i class='bx bx-chevron-down topbar__profile-icon'></i>
            </span>
            <div class="dropdown__menu">
                <a href="{{ route('profile.view') }}">
                    <i class='bx bx-user'></i> View Profile
                </a>
                <a href="{{ route('study-partner.social-profile.show', Auth::user()->id) }}">
                    <i class='bx bx-id-card'></i> My Social Profile
                </a>
                <a href="{{ route('analytics') }}">
                    <i class='bx bx-chart'></i> Analytics
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Notification Styles -->
<style>
    /* Notification Dropdown Container */
    .topbar__notification-dropdown {
        position: relative;
    }

    .topbar__notification-trigger {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .topbar__notification-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #dc2626;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 0.688rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    /* Notification Menu */
    .topbar__notification-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 380px;
        max-height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
    }

    .topbar__notification-menu.show {
        display: flex;
    }

    /* Notification Header */
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .notification-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    .mark-all-read {
        font-size: 0.813rem;
        color: #8c52ff;
        text-decoration: none;
        font-weight: 500;
    }

    .mark-all-read:hover {
        text-decoration: underline;
    }

    /* Notification List */
    .notification-list {
        overflow-y: auto;
        max-height: 350px;
    }

    .notification-item {
        display: flex;
        align-items: start;
        padding: 0.875rem 1rem;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
        position: relative;
    }

    .notification-item:hover {
        background-color: #f9fafb;
    }

    .notification-item.unread {
        background-color: #f0f4ff;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ede9fe;
        border-radius: 50%;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .notification-icon i {
        font-size: 1.25rem;
        color: #8c52ff;
    }

    /* Icon color overrides */
    .notification-icon i.text-danger { color: #dc2626 !important; }
    .notification-icon i.text-success { color: #16a34a !important; }
    .notification-icon i.text-primary { color: #2563eb !important; }
    .notification-icon i.text-warning { color: #f59e0b !important; }
    .notification-icon i.text-secondary { color: #6b7280 !important; }

    .notification-content {
        flex: 1;
    }

    .notification-item-title {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        font-size: 0.875rem;
        color: #1f2937;
    }

    .notification-item-message {
        margin: 0 0 0.25rem 0;
        font-size: 0.813rem;
        color: #6b7280;
        line-height: 1.4;
    }

    .notification-item-time {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background: #8c52ff;
        border-radius: 50%;
        flex-shrink: 0;
        margin-left: 0.5rem;
        margin-top: 0.5rem;
    }

    /* Empty State */
    .notification-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #9ca3af;
    }

    .notification-empty i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .notification-empty p {
        margin: 0;
        font-size: 0.875rem;
    }

    /* Footer with Show All Button */
    .notification-footer {
        border-top: 1px solid #e5e7eb;
        background: #fafafa;
    }

    .notification-show-all {
        display: block;
        text-align: center;
        padding: 0.875rem;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .notification-show-all:hover {
        background: #f3f4f6;
        color: #8c52ff;
    }

    /* Scrollbar */
    .notification-list::-webkit-scrollbar {
        width: 6px;
    }

    .notification-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .notification-list::-webkit-scrollbar-thumb {
        background: #c0c0c0;
        border-radius: 3px;
    }

    .notification-list::-webkit-scrollbar-thumb:hover {
        background: #a0a0a0;
    }
</style>

<!-- Notification Scripts -->
<script>
    // Toggle notification dropdown
    document.getElementById('notificationBell').addEventListener('click', function(e) {
        e.preventDefault();
        const menu = document.getElementById('notificationMenu');
        menu.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.querySelector('.topbar__notification-dropdown');
        const menu = document.getElementById('notificationMenu');
        
        if (!dropdown.contains(e.target)) {
            menu.classList.remove('show');
        }
    });

    // Mark notification as read
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        }).then(() => {
            const item = event.currentTarget;
            item.classList.remove('unread');
            const dot = item.querySelector('.unread-dot');
            if (dot) dot.remove();
            
            // Update badge count
            updateBadgeCount();
        });
    }

    // Update notification badge count
    function updateBadgeCount() {
        fetch('/notifications/unread-count', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.topbar__notification-badge');
                if (data.count > 0) {
                    if (badge) {
                        badge.textContent = data.count > 9 ? '9+' : data.count;
                    } else {
                        // Create badge if not exist
                        const trigger = document.querySelector('.topbar__notification-trigger');
                        const newBadge = document.createElement('span');
                        newBadge.className = 'topbar__notification-badge';
                        newBadge.textContent = data.count > 9 ? '9+' : data.count;
                        trigger.appendChild(newBadge);
                    }
                } else {
                    if (badge) {
                        badge.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching notification count:', error);
            });
    }

    // Poll for new notifications every 30 seconds
    setInterval(updateBadgeCount, 30000);
</script>