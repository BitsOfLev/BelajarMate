<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // Mark all existing users as verified
        User::whereNull('email_verified_at')->update([
            'email_verified_at' => now()
        ]);
    }

    public function down(): void
    {
        
    }
};
