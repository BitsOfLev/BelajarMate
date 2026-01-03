<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('education_levels')->insert([
            ['edulvlType' => 'Diploma'],
            ['edulvlType' => 'Degree'],
            ['edulvlType' => 'Master'],
            ['edulvlType' => 'PhD'],
        ]);
    }
}

