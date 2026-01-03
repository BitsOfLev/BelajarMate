<div class="conversations-sidebar" id="conversationsSidebar">
    
    {{-- Sidebar Header --}}
    <div class="sidebar-header">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            {{-- Back button for mobile (when chat is open) --}}
            <button 
                type="button" 
                class="btn-back-mobile d-md-none"
                onclick="showConversationList()"
                style="width: 36px; height: 36px; background: #f3f4f6; color: #6b7280; border: none; border-radius: 8px; font-size: 1.125rem; cursor: pointer; display: none; align-items: center; justify-content: center; margin-right: 8px;"
            >
                <i class="bi bi-arrow-left"></i>
            </button>
            
            <h2 class="sidebar-title" style="margin: 0;">Conversations</h2>
            <button 
                type="button" 
                class="btn-new-message"
                onclick="showNewMessageModal()"
                data-bs-toggle="tooltip"
                data-bs-placement="left"
                title="New message"
                style="width: 36px; height: 36px; background: var(--bm-purple); color: white; border: none; border-radius: 8px; font-size: 1.125rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'"
                onmouseout="this.style.transform='scale(1)'"
            >
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input 
                type="text" 
                placeholder="Search conversations..." 
                id="conversationSearch"
            >
        </div>
    </div>

    {{-- Conversations List --}}
    <div class="conversations-list" id="conversationsList">
        @if($conversations->count() > 0)
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->getOtherUser(auth()->id());
                    $lastMessage = $conversation->lastMessage;
                    $unreadCount = $conversation->unreadCount(auth()->id());
                    $isActive = $selectedConversation && $selectedConversation->id == $conversation->id;
                @endphp

                <a 
                    href="{{ route('messages.conversation.show', $conversation->id) }}" 
                    class="conversation-item {{ $isActive ? 'active' : '' }}"
                    data-conversation-id="{{ $conversation->id }}"
                    onclick="showChatWindow(event)"
                >
                    {{-- Avatar with Profile Picture --}}
                    <div class="conversation-avatar">
                        @if($otherUser->userInfo && $otherUser->userInfo->profile_image)
                            <img 
                                src="{{ asset('storage/' . $otherUser->userInfo->profile_image) }}"
                                alt="{{ $otherUser->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                            >
                        @else
                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="conversation-info">
                        <div class="conversation-name">{{ $otherUser->name }}</div>
                        <div class="conversation-preview">
                            @if($lastMessage)
                                @if($lastMessage->sender_id == auth()->id())
                                    <span style="font-weight: 600;">You:</span>
                                @endif
                                
                                @if($lastMessage->message)
                                    {{ Str::limit($lastMessage->message, 40) }}
                                @elseif($lastMessage->attachment_type == 'image')
                                    <i class="bi bi-image"></i> Photo
                                @elseif($lastMessage->attachment_type == 'pdf')
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                @endif
                            @else
                                <span style="font-style: italic; color: #d1d5db;">Start a conversation</span>
                            @endif
                        </div>
                    </div>

                    {{-- Meta --}}
                    <div class="conversation-meta">
                        @if($lastMessage)
                            <div class="conversation-time">
                                {{ $lastMessage->created_at->diffForHumans(null, true, true) }}
                            </div>
                        @endif
                        
                        @if($unreadCount > 0)
                            <div class="unread-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</div>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            {{-- Empty State --}}
            <div class="empty-conversations">
                <i class="bi bi-chat-dots"></i>
                <p><strong>No conversations yet</strong></p>
                <p>Start messaging your study partners</p>
            </div>
        @endif
    </div>

</div>

<script>
    // Search conversations
    const searchInput = document.getElementById('conversationSearch');
    const conversationItems = document.querySelectorAll('.conversation-item');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            conversationItems.forEach(item => {
                const name = item.querySelector('.conversation-name').textContent.toLowerCase();
                const preview = item.querySelector('.conversation-preview').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || preview.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Mobile navigation
    function showChatWindow(event) {
        if (window.innerWidth <= 768) {
            event.preventDefault();
            const href = event.currentTarget.href;
            
            // Hide sidebar, show chat
            document.getElementById('conversationsSidebar').classList.add('mobile-hide');
            document.getElementById('chatWindow').classList.remove('mobile-hide');
            document.querySelector('.btn-back-mobile').style.display = 'none';
            
            // Navigate
            window.location.href = href;
        }
    }

    function showConversationList() {
        document.getElementById('conversationsSidebar').classList.remove('mobile-hide');
        document.getElementById('chatWindow').classList.add('mobile-hide');
    }
</script>