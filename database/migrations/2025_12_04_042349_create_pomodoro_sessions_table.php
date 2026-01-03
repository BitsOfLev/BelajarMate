<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pomodoro_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pomodoro_preset_id')->constrained('pomodoro_presets')->onDelete('cascade');

            $table->foreignId('planner_id')->nullable()->constrained('study_planners')->onDelete('set null');

            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->integer('cycles_completed')->default(0);
            $table->integer('total_focus_minutes')->default(0);
            $table->integer('total_break_minutes')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pomodoro_sessions');
    }
};

