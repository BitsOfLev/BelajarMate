<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogLike extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'likeID';

    protected $fillable = [
        'blogID',
        'userID',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blogID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
