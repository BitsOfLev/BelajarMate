<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
        CourseCategory::create([
            'category_name' => 'Technology & Computing',
            'description' => 'Courses related to computing and information technology',
        ]);
    }
}

