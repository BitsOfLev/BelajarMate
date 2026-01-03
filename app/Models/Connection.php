<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $primaryKey = 'connectionID';

    protected $fillable = [
        'requesterID',
        'receiverID',
        'connection_status',
    ];

    // Status constants
    public const STATUS_PENDING  = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_BLOCKED  = 'blocked';

    // Relations
    public function requester()
    {
        return $this->belongsTo(User::class, 'requesterID');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiverID');
    }

    // scope helpers
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('requesterID', $userId)->orWhere('receiverID', $userId);
        });
    }
} 
