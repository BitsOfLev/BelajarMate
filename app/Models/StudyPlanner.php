<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studyPlanName', 
        'category_id', 
        'priority',
        'description',
        'start_date',
        'due_date',
    ];

    // Relationship with tasks
    public function tasks()
    {
        return $this->hasMany(StudyTask::class, 'study_plan_id');
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(StudyCategory::class, 'category_id');
    }

    // Accessor for total tasks
    public function getTotalTasksAttribute()
    {
        return $this->tasks()->count();
    }

    // Accessor for completed tasks
    public function getCompletedTasksAttribute()
    {
        return $this->tasks()->where('taskStatus', 1)->count(); // or true
    }
}



 
 