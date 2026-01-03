<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmittedByToUniversitiesAndCoursesTables extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropColumn('submitted_by');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropColumn('submitted_by');
        });
    }
}




