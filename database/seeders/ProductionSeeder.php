<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        // 1. Create admin account
        User::create([
            'name' => 'Admin BelajarMate',
            'email' => 'admin@belajarmate.com',
            'password' => Hash::make('AdminDemo123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Create demo student
        User::create([
            'name' => 'Sarah Ahmad',
            'email' => 'sarah@demo.com',
            'password' => Hash::make('Demo123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Add more later after we get Railway working
        
        echo "✅ Production data seeded!\n";
    }
}
