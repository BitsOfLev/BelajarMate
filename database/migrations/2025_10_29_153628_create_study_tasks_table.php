<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('study_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_plan_id');
            $table->string('taskName');
            $table->enum('taskStatus', ['Pending', 'Completed'])->default('Pending');
            $table->timestamps();

            $table->foreign('study_plan_id')->references('id')->on('study_planners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_tasks');
    }
};
