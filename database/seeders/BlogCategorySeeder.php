<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Study Tips & Productivity',
            'Course & Subject Notes',
            'Projects & Research',
            'Campus Life & Activities',
            'Career & Internships',
            'Tech & Tools for Students',
            'University Experiences',
        ];

        foreach ($categories as $categoryName) {
            BlogCategory::create(['categoryName' => $categoryName]);
        }
    }
}

