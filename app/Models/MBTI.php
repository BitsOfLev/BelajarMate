<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mbti extends Model
{
    use HasFactory;

    protected $table = 'mbti_types';
    protected $primaryKey = 'mbtiID';
    public $timestamps = true; // since created_at and updated_at exist

    protected $fillable = ['mbti'];

    // Optional: map a 'type' attribute for convenience in views
    public function getTypeAttribute()
    {
        return $this->mbti;
    }
}
