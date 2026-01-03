<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first user in the conversation
     */
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Get the second user in the conversation
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get all messages in this conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the other user in the conversation (not the current user)
     */
    public function getOtherUser($currentUserId)
    {
        return $this->user_one_id == $currentUserId 
            ? $this->userTwo 
            : $this->userOne;
    }

    /**
     * Scope to get conversations for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_one_id', $userId)
                    ->orWhere('user_two_id', $userId);
    }

    /**
     * Get unread message count for a specific user
     */
    public function unreadCount($userId)
    {
        return $this->messages()
                    ->where('sender_id', '!=', $userId)
                    ->where('is_read', false)
                    ->count();
    }

    /**
     * Get the last message in the conversation
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
