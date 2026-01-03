<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PomodoroSession extends Model
{
    protected $fillable = [
        'user_id', 
        'pomodoro_preset_id', 
        'planner_id',
        'start_time', 
        'end_time', 
        'cycles_completed',
        'total_focus_minutes', 
        'total_break_minutes',
    ];

    public function preset()
    {
        return $this->belongsTo(PomodoroPreset::class, 'pomodoro_preset_id');
    }
}

