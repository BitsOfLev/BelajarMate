<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionInvite extends Model
{
    // Disable Laravel's automatic timestamp management
    public $timestamps = false;

    protected $table = 'session_invites';
    protected $primaryKey = 'inviteID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'sessionID',
        'invitedUserID',
        'invite_status',
        'invited_at',
        'responded_at',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    // Relationships
    public function session()
    {
        return $this->belongsTo(StudySession::class, 'sessionID', 'sessionID');
    }

    public function sessionWithTrashed()
    {
        return $this->belongsTo(StudySession::class, 'sessionID', 'sessionID')
                    ->withTrashed();
    }

    public function invitedUser()
    {
        return $this->belongsTo(User::class, 'invitedUserID', 'id');
    }
}

