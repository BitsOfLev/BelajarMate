<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'courseCategoryID';

    protected $fillable = ['category_name', 'description'];

    public $timestamps = true;

    public function courses()
    {
        return $this->hasMany(Course::class, 'courseCategoryID', 'courseCategoryID');
    }
}

