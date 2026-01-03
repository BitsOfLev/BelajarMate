<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pomodoro_presets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('preset_type', ['system', 'custom'])->default('custom');

            $table->string('title');

            $table->integer('work_minutes');
            $table->integer('short_break_minutes');
            $table->integer('long_break_minutes');
            $table->integer('work_cycles'); // number of work sessions before long break

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pomodoro_presets');
    }
};
