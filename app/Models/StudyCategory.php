<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyCategory extends Model
{
    use HasFactory;

    // Table name (optional if it follows convention)
    protected $table = 'study_categories';

    // Fillable fields
    protected $fillable = [
        'name',
    ];

    // A category has many study planners
    public function planners()
    {
        return $this->hasMany(StudyPlanner::class, 'category_id');
    }
}
