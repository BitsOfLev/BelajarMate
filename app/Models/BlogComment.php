<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'commentID';

    protected $fillable = [
        'blogID',
        'userID',
        'commentText',
        'status',
        'flag_reason',
    ];

    // Status constants
    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';

    protected static function boot()
    {
        parent::boot();
        
        // When a comment is deleted, also delete its reports
        static::deleting(function ($comment) {
            \App\Models\BlogReport::where('commentID', $comment->commentID)->delete();
        });
    }

    // Relationships
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blogID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function reports()
    {
        return $this->hasMany(BlogReport::class, 'commentID');
    }

    // Scope: Only approved comments
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }
}

