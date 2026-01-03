<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'blogID';
    
    // Add this - tell Laravel to handle timestamps
    public $timestamps = true;

    protected $fillable = [
        'userID',
        'categoryID',
        'blogTitle',
        'blogContent',
        'blogImg',
        'status',
        'flag_reason',
        'posted_at'
    ];

    // ADD THIS - Cast posted_at to Carbon date
    protected $casts = [
        'posted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Status constants
    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'categoryID');
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class, 'blogID');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blogID')->where('status', 'approved');
    }

    public function reports()
    {
        return $this->hasMany(BlogReport::class, 'blogID');
    }

    // Check if blog is flagged/pending
    public function getIsFlaggedAttribute()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the blog is liked by a specific user
     */
    public function isLikedBy($userId)
    {
        if (!$userId) {
            return false;
        }
        
        return $this->likes()
            ->where('userID', $userId)
            ->exists();
    }

    // Scope: Only approved blogs
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    // Scope: Blogs from user's friends
    public function scopeFromFriends($query, $userId)
    {
        $friendIds = \App\Models\Connection::forUser($userId)
            ->where('connection_status', \App\Models\Connection::STATUS_ACCEPTED)
            ->get()
            ->map(function ($connection) use ($userId) {
                return $connection->requesterID == $userId 
                    ? $connection->receiverID 
                    : $connection->requesterID;
            })
            ->toArray();

        return $query->whereIn('userID', $friendIds);
    }
}
