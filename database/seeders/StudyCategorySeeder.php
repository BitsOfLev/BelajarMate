<?php

namespace Database\Seeders;

use App\Models\StudyCategory;
use Illuminate\Database\Seeder;

class StudyCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Exam', 'Project', 'Quiz', 'Midterm', 'Assignment', 'Other'];
        foreach ($categories as $cat) {
            StudyCategory::firstOrCreate(['name' => $cat]);
        }
    }
}

