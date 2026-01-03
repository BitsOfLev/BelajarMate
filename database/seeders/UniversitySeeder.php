<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('universities')->insert([
            ['uniName' => 'Universiti Malaysia Sabah', 'approval_status' => 'approved'],
            ['uniName' => 'Universiti Malaya', 'approval_status' => 'approved'],
            ['uniName' => 'Universiti Teknologi MARA', 'approval_status' => 'approved'],
            ['uniName' => 'Universiti Kebangsaan Malaysia', 'approval_status' => 'approved'],
            ['uniName' => 'Universiti Sains Malaysia', 'approval_status' => 'approved'],
        ]);
    }
}

