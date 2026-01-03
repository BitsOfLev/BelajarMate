<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendation'; 
    
    protected $fillable = [
        'userID',
        'recommendedUserID',
        'score',
        'factors',
        'timestamp'
    ];

    protected $casts = [
        'factors' => 'array',
        'timestamp' => 'datetime'
    ];

    // Relationship to the user who received the recommendation
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // Relationship to the recommended user
    public function recommendedUser()
    {
        return $this->belongsTo(User::class, 'recommendedUserID');
    }
}

