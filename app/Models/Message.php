<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'attachment_path',
        'attachment_name',
        'attachment_type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the conversation this message belongs to
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Mark this message as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update(['is_read' => true]);
        }
    }

    /**
     * Check if message has an attachment
     */
    public function hasAttachment()
    {
        return !is_null($this->attachment_path);
    }

    /**
     * Get the full URL for the attachment
     */
    public function getAttachmentUrl()
    {
        if ($this->hasAttachment()) {
            return asset('storage/' . $this->attachment_path);
        }
        return null;
    }

    /**
     * Check if attachment is an image
     */
    public function isImageAttachment()
    {
        return $this->attachment_type === 'image';
    }

    /**
     * Check if attachment is a PDF
     */
    public function isPdfAttachment()
    {
        return $this->attachment_type === 'pdf';
    }
}
