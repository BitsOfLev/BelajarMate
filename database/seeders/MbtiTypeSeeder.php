<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MbtiTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mbti_types')->insert([
            ['mbti' => 'INTJ'],
            ['mbti' => 'INTP'],
            ['mbti' => 'ENTJ'],
            ['mbti' => 'ENTP'],
            ['mbti' => 'INFJ'],
            ['mbti' => 'INFP'],
            ['mbti' => 'ENFJ'],
            ['mbti' => 'ENFP'],
            ['mbti' => 'ISTJ'],
            ['mbti' => 'ISFJ'],
            ['mbti' => 'ESTJ'],
            ['mbti' => 'ESFJ'],
            ['mbti' => 'ISTP'],
            ['mbti' => 'ISFP'],
            ['mbti' => 'ESTP'],
            ['mbti' => 'ESFP'],
        ]);
    }
}
