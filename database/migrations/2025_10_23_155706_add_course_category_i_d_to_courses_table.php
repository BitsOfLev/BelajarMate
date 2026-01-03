<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('courseCategoryID')->nullable()->after('courseName');
            $table->foreign('courseCategoryID')->references('courseCategoryID')->on('course_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['courseCategoryID']);
            $table->dropColumn('courseCategoryID');
        });
    }
};

