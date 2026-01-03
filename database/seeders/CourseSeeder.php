<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            ['courseName' => 'Software Engineering', 'approval_status' => 'approved'],
            ['courseName' => 'Information Technology', 'approval_status' => 'approved'],
            ['courseName' => 'Computer Science', 'approval_status' => 'approved'],
            ['courseName' => 'Data Science', 'approval_status' => 'approved'],
            ['courseName' => 'Artificial Intelligence', 'approval_status' => 'approved'],
        ]);
    }
}

