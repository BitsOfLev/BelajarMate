<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->string('study_schedule')->nullable()->after('profile_image');
        });
    }

    public function down(): void
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->dropColumn('study_schedule');
        });
    }
};
