<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;
use App\Models\Connection;
use App\Models\BlogReport;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relationship to UserInfo
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'userID');
    }

    /*************
     * Connection
    **************/
    // requests that this user sent
    public function sentConnections()
    {
        return $this->hasMany(\App\Models\Connection::class, 'requesterID');
    }

    // requests that this user received
    public function receivedConnections()
    {
        return $this->hasMany(\App\Models\Connection::class, 'receiverID');
    }

    // accepted connections (both directions) convenience
    public function acceptedConnections()
    {
        return \App\Models\Connection::forUser($this->id)
            ->where('connection_status', \App\Models\Connection::STATUS_ACCEPTED);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'userID');
    }

    public function blogLikes()
    {
        return $this->hasMany(BlogLike::class, 'userID');
    }

    public function blogComments()
    {
        return $this->hasMany(BlogComment::class, 'userID');
    }

    //Get count of unread messages for this user
    public function getUnreadMessagesCount()
    {
        return Message::whereHas('conversation', function($query) {
                $query->where('user_one_id', $this->id)
                    ->orWhere('user_two_id', $this->id);
            })
            ->where('sender_id', '!=', $this->id)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get all accepted study partners
     */
    public function connectedPartners()
    {
        $connections = Connection::forUser($this->id)
            ->where('connection_status', Connection::STATUS_ACCEPTED)
            ->with(['requester', 'receiver'])
            ->get();
        
        // Get the other user in each connection
        return $connections->map(function ($connection) {
            return $connection->requesterID == $this->id 
                ? $connection->receiver 
                : $connection->requester;
        });
    }

    /**
     * Get all study sessions created by this user
     */
    public function studySessions()
    {
        return $this->hasMany(StudySession::class, 'userID');
    }

    /**
     * Get recommendations for this user with scores
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'userID');
    }

    /**
     * Get all reports filed by this user
     */
    public function reports()
    {
        return $this->hasMany(BlogReport::class, 'userID');
    }


}


