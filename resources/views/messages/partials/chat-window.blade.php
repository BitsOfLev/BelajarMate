{{-- Chat Messages --}}
<div class="chat-window" id="chatWindow">
    
    @if($selectedConversation)
        @php
            $otherUser = $selectedConversation->getOtherUser(auth()->id());
            $areConnected = \App\Models\Connection::where(function ($query) use ($otherUser) {
                    $query->where('requesterID', auth()->id())->where('receiverID', $otherUser->id);
                })->orWhere(function ($query) use ($otherUser) {
                    $query->where('requesterID', $otherUser->id)->where('receiverID', auth()->id());
                })->where('connection_status', \App\Models\Connection::STATUS_ACCEPTED)->exists();
        @endphp

        {{-- Chat Header --}}
        <div class="chat-header">
            {{-- Back button for mobile --}}
            <button 
                type="button" 
                class="btn-back-mobile d-md-none"
                onclick="showConversationList()"
                style="width: 36px; height: 36px; background: #f3f4f6; color: #6b7280; border: none; border-radius: 8px; font-size: 1.125rem; cursor: pointer; display: flex; align-items: center; justify-content: center; margin-right: 8px;"
            >
                <i class="bi bi-arrow-left"></i>
            </button>
            
            {{-- Clickable Avatar --}}
            <a href="{{ route('study-partner.social-profile.show', $otherUser->id) }}" class="chat-user-avatar" style="text-decoration: none; cursor: pointer;">
                @if($otherUser->userInfo && $otherUser->userInfo->profile_image)
                    <img 
                        src="{{ asset('storage/' . $otherUser->userInfo->profile_image) }}"
                        alt="{{ $otherUser->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                    >
                @else
                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                @endif
            </a>
            
            {{-- Clickable User Info --}}
            <div class="chat-user-info">
                <a href="{{ route('study-partner.social-profile.show', $otherUser->id) }}" style="text-decoration: none; color: inherit;">
                    <h3 style="cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#8c52ff'" onmouseout="this.style.color='#111827'">
                        {{ $otherUser->name }}
                    </h3>
                </a>
                <p>Study Partner</p>
            </div>
        </div>

        {{-- Disconnected Warning (if not connected) --}}
        @if(!$areConnected)
            <div style="padding: 16px 24px; background: #fef3c7; border-bottom: 1px solid #fde68a; display: flex; align-items: center; gap: 12px;">
                <i class="bi bi-exclamation-triangle-fill" style="color: #f59e0b; font-size: 1.25rem;"></i>
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: #92400e; font-size: 0.875rem;">Connection Removed</div>
                    <div style="font-size: 0.813rem; color: #78350f;">You are no longer connected with this user. Messages are read-only.</div>
                </div>
            </div>
        @endif

        {{-- Chat Messages --}}
        <div class="chat-messages">
            @if($messages->count() > 0)
                @php
                    $lastDate = null;
                @endphp

                @foreach($messages as $message)
                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                    @endphp

                    {{-- Date Divider --}}
                    @if($lastDate != $messageDate)
                        <div class="date-divider">
                            @if($message->created_at->isToday())
                                Today
                            @elseif($message->created_at->isYesterday())
                                Yesterday
                            @else
                                {{ $message->created_at->format('F j, Y') }}
                            @endif
                        </div>
                        @php $lastDate = $messageDate; @endphp
                    @endif

                    {{-- Include Message Item Partial --}}
                    @include('messages.partials.message-item', ['message' => $message])

                @endforeach
            @else
                {{-- No messages yet --}}
                <div class="empty-chat">
                    <i class="bi bi-chat-dots"></i>
                    <h3>No messages yet</h3>
                    <p>Start the conversation with {{ $otherUser->name }}</p>
                </div>
            @endif
        </div>

        {{-- Chat Input --}}
        <div class="chat-input-container" style="{{ !$areConnected ? 'opacity: 0.5; pointer-events: none;' : '' }}">
            <form 
                action="{{ route('messages.conversation.store', $selectedConversation->id) }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="chat-input-form"
            >
                @csrf

                <div class="input-wrapper">
                    {{-- File Preview --}}
                    <div id="filePreview" class="file-preview" style="display: none;">
                        <i class="bi bi-paperclip"></i>
                        <span id="fileName"></span>
                        <button type="button" id="removeFile">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    {{-- Message Input --}}
                    <textarea 
                        name="message" 
                        class="message-textarea" 
                        placeholder="{{ $areConnected ? 'Type a message...' : 'Cannot send messages - connection removed' }}"
                        rows="1"
                        {{ !$areConnected ? 'disabled' : '' }}
                    ></textarea>
                </div>

                <div class="input-actions">
                    {{-- Attachment Button --}}
                    <label for="attachment" class="btn-attachment" style="{{ !$areConnected ? 'cursor: not-allowed;' : '' }}">
                        <i class="bi bi-paperclip"></i>
                        <input 
                            type="file" 
                            name="attachment" 
                            id="attachment" 
                            accept=".jpg,.jpeg,.png,.gif,.webp,.pdf"
                            style="display: none;"
                            {{ !$areConnected ? 'disabled' : '' }}
                        >
                    </label>

                    {{-- Send Button --}}
                    <button type="submit" class="btn-send" {{ !$areConnected ? 'disabled' : '' }}>
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>

    @else
        {{-- No Conversation Selected --}}
        <div class="empty-chat">
            <i class="bi bi-chat-square-text"></i>
            <h3>Select a conversation</h3>
            <p>Choose a conversation from the list to start messaging</p>
        </div>
    @endif

</div>
