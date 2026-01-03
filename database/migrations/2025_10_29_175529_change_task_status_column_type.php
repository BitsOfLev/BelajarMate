<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('study_tasks', function (Blueprint $table) {
            // Change taskStatus to boolean
            $table->boolean('taskStatus')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('study_tasks', function (Blueprint $table) {
            // Revert back if needed
            $table->string('taskStatus')->nullable()->change();
        });
    }
};
