<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_plan_id',
        'taskName',
        'taskStatus',
    ];

    // Cast to boolean
    protected $casts = [
        'taskStatus' => 'boolean',
    ];

    // Task belongs to a planner
    public function planner()
    {
        return $this->belongsTo(StudyPlanner::class, 'study_plan_id');
    }
}
 
 