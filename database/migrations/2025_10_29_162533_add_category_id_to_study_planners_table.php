<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_planners', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('studyPlanName');
            $table->foreign('category_id')->references('id')->on('study_categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('study_planners', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

