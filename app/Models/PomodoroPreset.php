<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PomodoroPreset extends Model
{
    protected $fillable = [
        'user_id', 
        'preset_type', 
        'title', 
        'work_minutes', 
        'short_break_minutes', 
        'long_break_minutes', 
        'work_cycles',
    ];

    public function sessions()
    {
        return $this->hasMany(PomodoroSession::class);
    }
}
