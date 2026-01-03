<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $users = [
            ['name' => 'User 2', 'email' => 'user2@example.com'],
            ['name' => 'User 3', 'email' => 'user3@example.com'],
            ['name' => 'User 4', 'email' => 'user4@example.com'],
            ['name' => 'User 5', 'email' => 'user5@example.com'],
            ['name' => 'User 6', 'email' => 'user6@example.com'],
            ['name' => 'User 7', 'email' => 'user7@example.com'],
            ['name' => 'User 8', 'email' => 'user8@example.com'],
            ['name' => 'User 9', 'email' => 'user9@example.com'],
            ['name' => 'User 10', 'email' => 'user10@example.com'],
        ];

        foreach ($users as $index => $user) {
            $userId = DB::table('users')->insertGetId([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'email_verified_at' => $now,
                'remember_token' => \Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Fill user_info
            $info = [
                'userID' => $userId,
                'uniID' => ($index % 3 == 0) ? null : rand(1, 8), // every 3rd user missing uni
                'courseID' => ($index % 4 == 0) ? null : rand(1, 7), // every 4th user missing course
                'edulvlID' => 1, // Undergraduate
                'academicYear' => rand(1, 4),
                'preferred_mode' => 'Online',
                'preferred_time' => ($index % 5 == 0) ? null : 'Morning', // every 5th user missing time
                'mbtiID' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            DB::table('user_info')->insert($info);
        }
    }
}


