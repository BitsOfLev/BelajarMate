@extends('layouts.main')

@section('content')

<style>
    body {
        background: #fafbfc;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 24px;
    }

    /* Messages Container */
    .messages-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: calc(100vh - 200px);
        min-height: 600px;
        max-height: 800px; 
        display: grid;
        grid-template-columns: 360px 1fr;
    }

    /* Left Sidebar - Conversation List */
    .conversations-sidebar {
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        background: #fafbfc;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        background: white;
    }

    .sidebar-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 12px 0;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 10px 12px 10px 38px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.875rem;
        background: #f9fafb;
        transition: all 0.2s;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
        background: white;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .conversations-list {
        flex: 1;
        overflow-y: auto;
    }

    .conversation-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
    }

    .conversation-item:hover {
        background: #f9fafb;
    }

    .conversation-item.active {
        background: var(--bm-purple-lighter);
        border-left: 3px solid var(--bm-purple);
    }

    .conversation-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .conversation-info {
        flex: 1;
        min-width: 0;
    }

    .conversation-name {
        font-weight: 600;
        color: #111827;
        font-size: 0.938rem;
        margin-bottom: 4px;
    }

    .conversation-preview {
        font-size: 0.813rem;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conversation-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
        flex-shrink: 0;
    }

    .conversation-time {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .unread-badge {
        background: var(--bm-purple);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.688rem;
        font-weight: 700;
    }

    /* Empty State - No Conversations */
    .empty-conversations {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
        color: #9ca3af;
    }

    .empty-conversations i {
        font-size: 3rem;
        margin-bottom: 16px;
        color: #d1d5db;
    }

    .empty-conversations p {
        margin: 0;
        font-size: 0.875rem;
    }

    /* Right Panel - Chat Window */
    .chat-window {
        display: flex;
        flex-direction: column;
        background: white;
        height: 100%;
        overflow: hidden;
    }

    .chat-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        flex-shrink: 0; /* Don't allow header to shrink */
    }

    .chat-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--bm-purple-lighter);
        color: var(--bm-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        transition: transform 0.2s;
        overflow: hidden;
    }

    .chat-user-avatar:hover {
        transform: scale(1.05);
    }

    .chat-user-info h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .chat-user-info p {
        margin: 0;
        font-size: 0.813rem;
        color: #6b7280;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 24px;
        background: #fafbfc;
        display: flex;
        flex-direction: column;
    }

    /* Custom Scrollbar */
    .chat-messages::-webkit-scrollbar {
        width: 8px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: #f9fafb;
        border-radius: 10px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }

    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    .chat-messages {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db #f9fafb;
    }

    .chat-input-container {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: white;
        flex-shrink: 0; /* Don't allow input to shrink */
    }

    .message-group {
        margin-bottom: 16px;
    }

    .message-bubble {
        max-width: 70%;
        margin-bottom: 8px;
        display: flex;
        flex-direction: column;
    }

    .message-bubble.sent {
        margin-left: auto;
        align-items: flex-end;
    }

    .message-bubble.received {
        margin-right: auto;
        align-items: flex-start;
    }

    .message-content {
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 0.875rem;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .message-bubble.sent .message-content {
        background: var(--bm-purple);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message-bubble.received .message-content {
        background: white;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
    }

    .message-attachment {
        margin-top: 8px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .message-bubble.sent .message-attachment {
        background:var(--bm-purple);
        color: white;
    }

    .message-bubble.received .message-attachment {
        background: var(--bm-purple);
        color: white;
    }

    .message-attachment:hover {
        opacity: 0.8;
    }

    .attachment-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-size: 1.125rem;
    }

    .message-bubble.sent .attachment-icon {
        background: rgba(255, 0, 0, 0.64);
    }

    .message-bubble.received .attachment-icon {
        background: rgba(255, 0, 0, 0.64);
    }

    .attachment-info {
        flex: 1;
    }

    .attachment-name {
        font-size: 0.813rem;
        font-weight: 600;
        margin-bottom: 2px;
        color: #f6f7f9ff;
    }

    .attachment-type {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .message-attachment img {
        max-width: 200px;
        border-radius: 8px;
    }

    .message-time {
        font-size: 0.75rem;
        margin-top: 4px;
        opacity: 0.7;
    }

    .message-bubble.sent .message-time {
        color: #6b7280;
    }

    .message-bubble.received .message-time {
        color: #9ca3af;
    }

    .date-divider {
        text-align: center;
        margin: 24px 0;
        font-size: 0.75rem;
        color: #9ca3af;
        font-weight: 600;
    }

    /* Chat Input */
    .chat-input-container {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: white;
    }

    .chat-input-form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
    }

    .input-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .file-preview {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #f9fafb;
        border-radius: 8px;
        font-size: 0.813rem;
        color: #6b7280;
    }

    .file-preview button {
        margin-left: auto;
        background: none;
        border: none;
        color: #dc2626;
        cursor: pointer;
        padding: 0;
    }

    .message-textarea {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.875rem;
        resize: none;
        font-family: inherit;
        transition: all 0.2s;
        min-height: 48px;
        max-height: 120px;
    }

    .message-textarea:focus {
        outline: none;
        border-color: var(--bm-purple);
        box-shadow: 0 0 0 3px var(--bm-purple-lighter);
    }

    .input-actions {
        display: flex;
        gap: 8px;
    }

    .btn-attachment {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.125rem;
    }

    .btn-attachment:hover {
        background: #c3d5e7ff;
        border-color: var(--bm-purple);
        color: var(--bm-purple);
    }

    .btn-send {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: none;
        background: var(--bm-purple);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.125rem;
    }

    .btn-send:hover {
        background: var(--bm-purple-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-send:disabled {
        background: #d1d5db;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Empty Chat State */
        .empty-chat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1; /* Changed from height: 100% */
        color: #9ca3af;
        text-align: center;
        padding: 40px;
    }

    .empty-chat i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #d1d5db;
    }

    .empty-chat h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .empty-chat p {
        font-size: 0.938rem;
        margin: 0;
    }

    /* Alert Messages */
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
    }

    .alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .messages-container {
            grid-template-columns: 280px 1fr;
        }
    }

    @media (max-width: 768px) {
        .messages-container {
            grid-template-columns: 1fr;
            height: calc(100vh - 140px); /* Adjust for mobile */
            min-height: 500px;
        }

        .conversations-sidebar.mobile-hide {
            display: none !important;
        }

        .chat-window.mobile-hide {
            display: none !important;
        }

        .btn-back-mobile {
            display: flex !important;
        }

        .chat-messages {
            padding: 16px; /* Less padding on mobile */
        }
    }

    /* Mobile Responsive Updates */
    @media (max-width: 768px) {
        .messages-container {
            grid-template-columns: 1fr;
            height: calc(100vh - 160px);
        }

        .conversations-sidebar.mobile-hide {
            display: none !important;
        }

        .chat-window.mobile-hide {
            display: none !important;
        }

        .btn-back-mobile {
            display: flex !important;
        }
    }

    /* Profile picture in conversation list */
    .conversation-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Clickable profile in chat header */
    .chat-user-avatar {
        transition: transform 0.2s;
    }

    .chat-user-avatar:hover {
        transform: scale(1.05);
    }
</style>

<div class="container-fluid py-4">
    
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title">Messages</h1>
        <p class="page-subtitle">Connect with your study partners</p>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Messages Container --}}
    <div class="messages-container">
        
        {{-- Left Sidebar - Conversations List --}}
        @include('messages.partials.conversation-list', ['conversations' => $conversations, 'selectedConversation' => $selectedConversation])

        {{-- Right Panel - Chat Window --}}
        @include('messages.partials.chat-window', ['selectedConversation' => $selectedConversation, 'messages' => $messages])

    </div>

    {{-- New Message Modal --}}
    <div class="modal fade" id="newMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 16px;">Select a study partner to message:</p>
                    <div class="list-group">
                        @php
                            // Get connected study partners
                            $connectedPartners = Auth::user()->connectedPartners();
                        @endphp
                        
                        @if($connectedPartners->count() > 0)
                            @foreach($connectedPartners as $partner)
                                <form action="{{ route('messages.start', $partner->id) }}" method="POST" style="margin-bottom: 8px;">
                                    @csrf
                                    <button type="submit" class="list-group-item list-group-item-action" style="border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; padding: 12px; background: white; width: 100%; text-align: left; transition: all 0.2s;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bm-purple-lighter); color: var(--bm-purple); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; overflow: hidden;">
                                                @if($partner->userInfo && $partner->userInfo->profile_image)
                                                    <img 
                                                        src="{{ asset('storage/' . $partner->userInfo->profile_image) }}"
                                                        alt="{{ $partner->name }}"
                                                        style="width: 100%; height: 100%; object-fit: cover;"
                                                    >
                                                @else
                                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <strong style="color: #111827; font-size: 0.938rem;">{{ $partner->name }}</strong>
                                                <div style="font-size: 0.813rem; color: #6b7280;">Study Partner</div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px 20px;">
                                <i class="bi bi-people" style="font-size: 3rem; color: #d1d5db; margin-bottom: 16px;"></i>
                                <p style="color: #9ca3af; margin-bottom: 16px;">You don't have any study partners yet.</p>
                                <a href="{{ route('study-partner.index') }}" class="btn btn-primary">Find Study Partners</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });

    // Show new message modal
    function showNewMessageModal() {
        const modal = new bootstrap.Modal(document.getElementById('newMessageModal'));
        modal.show();
    }

    // Auto-scroll to bottom of messages
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // File attachment preview
    const fileInput = document.getElementById('attachment');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const removeFile = document.getElementById('removeFile');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                fileName.textContent = file.name;
                filePreview.style.display = 'flex';
            }
        });
    }

    if (removeFile) {
        removeFile.addEventListener('click', function() {
            fileInput.value = '';
            filePreview.style.display = 'none';
        });
    }

    // Auto-resize textarea
    const textarea = document.querySelector('.message-textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }

    // AJAX Polling for new messages
    @if($selectedConversation)
        let lastChecked = '{{ now()->toIso8601String() }}';
        const conversationId = {{ $selectedConversation->id }};

        setInterval(function() {
            fetch(`/messages/conversation/${conversationId}/check?last_checked=${lastChecked}`)
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        // Append new messages
                        data.newMessages.forEach(msg => {
                            appendMessage(msg);
                        });
                        
                        // Update last checked time
                        lastChecked = new Date().toISOString();
                        
                        // Scroll to bottom
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                        
                        // Mark as read
                        fetch(`/messages/conversation/${conversationId}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    }
                });
        }, 5000); // Check every 5 seconds

        function appendMessage(message) {
            const isSent = message.sender_id == {{ auth()->id() }};
            const bubbleClass = isSent ? 'sent' : 'received';
            
            let html = `
                <div class="message-bubble ${bubbleClass}">
                    ${message.message ? `<div class="message-content">${escapeHtml(message.message)}</div>` : ''}
                    ${message.attachment_path ? getAttachmentHtml(message, isSent) : ''}
                    <div class="message-time">${formatTime(message.created_at)}</div>
                </div>
            `;
            
            chatMessages.insertAdjacentHTML('beforeend', html);
        }

        function getAttachmentHtml(message, isSent) {
            if (message.attachment_type === 'image') {
                return `<img src="/storage/${message.attachment_path}" alt="Image" style="max-width: 200px; border-radius: 8px;">`;
            } else {
                return `
                    <a href="/storage/${message.attachment_path}" target="_blank" class="message-attachment">
                        <div class="attachment-icon">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div class="attachment-info">
                            <div class="attachment-name">${escapeHtml(message.attachment_name)}</div>
                            <div class="attachment-type">PDF Document</div>
                        </div>
                    </a>
                `;
            }
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    @endif
</script>

@endsection
