@php
    $isSent = $message->sender_id == auth()->id();
@endphp

<div class="message-bubble {{ $isSent ? 'sent' : 'received' }}">
    
    {{-- Text Message --}}
    @if($message->message)
        <div class="message-content">
            {{ $message->message }}
        </div>
    @endif

    {{-- Attachment --}}
    @if($message->hasAttachment())
        @if($message->isImageAttachment())
            {{-- Image Attachment --}}
            <a href="{{ $message->getAttachmentUrl() }}" target="_blank">
                <img 
                    src="{{ $message->getAttachmentUrl() }}" 
                    alt="{{ $message->attachment_name }}"
                    style="max-width: 200px; border-radius: 8px; cursor: pointer; margin-top: 8px;"
                >
            </a>
        @elseif($message->isPdfAttachment())
            {{-- PDF Attachment --}}
            <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="message-attachment">
                <div class="attachment-icon">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div class="attachment-info">
                    <div class="attachment-name">{{ $message->attachment_name }}</div>
                    <div class="attachment-type">PDF Document</div>
                </div>
                <i class="bi bi-download" style="font-size: 1rem;"></i>
            </a>
        @endif
    @endif

    {{-- Timestamp --}}
    <div class="message-time">
        {{ $message->created_at->format('g:i A') }}
    </div>
</div>