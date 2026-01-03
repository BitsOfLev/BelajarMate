<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogReport extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'reportID';

    protected $fillable = [
        'userID',
        'blogID',
        'commentID',
        'report_reason',
        'status',
        'admin_notes',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_DISMISSED = 'dismissed';
    const STATUS_INVESTIGATING = 'investigating';

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blogID');
    }

    public function comment()
    {
        return $this->belongsTo(BlogComment::class, 'commentID');
    }

    // Check if report is for a blog or comment
    public function getReportTypeAttribute()
    {
        return $this->blogID ? 'blog' : 'comment';
    }
}