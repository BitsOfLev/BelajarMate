<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'courseID';
    public $timestamps = true;

    protected $fillable = [
        'courseName', 
        'courseCategoryID',
        'approval_status', 
        'submitted_by'
    ];

    public function submittedBy()
    { 
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function getNameAttribute()
    {
        return $this->courseName;
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'courseCategoryID', 'courseCategoryID');
    }
}
