<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
 
    protected $table = 'user_info';
    protected $primaryKey = 'userInfoID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'uniID',
        'courseID',
        'edulvlID',
        'mbtiID',
        'academicYear',
        'aboutMe',
        'preferred_time',
        'preferred_mode',
        'profile_image',
        'study_schedule', // NEW
    ];

    //Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // Relationship to University
    public function university()
    {
        return $this->belongsTo(University::class, 'uniID', 'uniID');
    }

    // Relationship to Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseID', 'courseID');
    }

    // Relationship to Education Level
    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'edulvlID', 'edulvlID');
    }

    // Relationship to MBTI
    public function mbti()
    {
        return $this->belongsTo(MBTI::class, 'mbtiID', 'mbtiID');
    }

    // Mutators: safely handle arrays or strings when saving
    public function setPreferredTimeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['preferred_time'] = implode(',', $value);
        } elseif (is_string($value)) {
            $this->attributes['preferred_time'] = $value;
        } else {
            $this->attributes['preferred_time'] = null;
        }
    }

    public function setPreferredModeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['preferred_mode'] = implode(',', $value);
        } elseif (is_string($value)) {
            $this->attributes['preferred_mode'] = $value;
        } else {
            $this->attributes['preferred_mode'] = null;
        }
    }

    // Accessors: always return arrays for checkboxes
    public function getPreferredTimeAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getPreferredModeAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }
}

