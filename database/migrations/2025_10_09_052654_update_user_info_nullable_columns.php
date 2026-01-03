<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->unsignedBigInteger('uniID')->nullable()->change();
            $table->unsignedBigInteger('courseID')->nullable()->change();
            $table->unsignedBigInteger('edulvlID')->nullable()->change();
            $table->unsignedBigInteger('mbtiID')->nullable()->change();
            $table->string('academicYear')->nullable()->change();
            $table->text('aboutMe')->nullable()->change();
            $table->string('preferred_time')->nullable()->change();
            $table->string('preferred_mode')->nullable()->change();
            $table->string('profile_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->unsignedBigInteger('uniID')->nullable(false)->change();
            $table->unsignedBigInteger('courseID')->nullable(false)->change();
            $table->unsignedBigInteger('edulvlID')->nullable(false)->change();
            $table->unsignedBigInteger('mbtiID')->nullable(false)->change();
            $table->string('academicYear')->nullable(false)->change();
            $table->text('aboutMe')->nullable(false)->change();
            $table->string('preferred_time')->nullable(false)->change();
            $table->string('preferred_mode')->nullable(false)->change();
            $table->string('profile_image')->nullable(false)->change();
        });
    }
};

