<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id('userInfoID'); // PK

            // Foreign Keys
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('uniID');
            $table->unsignedBigInteger('courseID');
            $table->unsignedBigInteger('edulvlID');
            $table->unsignedBigInteger('mbtiID');

            // Other fields
            $table->integer('academicYear')->nullable();
            $table->text('aboutMe')->nullable();
           

            $table->set('preferred_time', ['morning', 'noon', 'evening', 'night', 'late night'])->nullable();
            $table->set('preferred_mode', ['online', 'offline', 'hybrid'])->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('uniID')->references('uniID')->on('universities')->onDelete('restrict');
            $table->foreign('courseID')->references('courseID')->on('courses')->onDelete('restrict');
            $table->foreign('edulvlID')->references('edulvlID')->on('education_levels')->onDelete('restrict');
            $table->foreign('mbtiID')->references('mbtiID')->on('mbti_types')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_info');
    }
};

