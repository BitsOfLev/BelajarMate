<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudySession extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'study_sessions';
    protected $primaryKey = 'sessionID';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'userID',
        'sessionName',
        'sessionDate',
        'sessionTime',
        'endTime',
        'sessionMode',
        'sessionDetails',
        'status',
        'location',
        'meeting_link',
    ];

    protected $casts = [
        'sessionDate' => 'date',
        'sessionTime' => 'datetime:H:i:s',  
        'endTime' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }

    public function invites()
    {
        return $this->hasMany(SessionInvite::class, 'sessionID', 'sessionID');
    }

    protected static function boot()
    {
        parent::boot();

        // When session is soft deleted, delete all its invites
        static::deleting(function($session) {
            $session->invites()->delete();
        });
    }
}
