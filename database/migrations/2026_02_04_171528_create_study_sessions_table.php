<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id('sessionID');
            $table->unsignedBigInteger('userID');
            $table->string('sessionName', 150);
            $table->date('sessionDate');
            $table->time('sessionTime');
            $table->time('endTime')->nullable();
            $table->enum('sessionMode', ['online', 'face-to-face']);
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('sessionDetails')->nullable();
            $table->enum('status', ['planned', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
