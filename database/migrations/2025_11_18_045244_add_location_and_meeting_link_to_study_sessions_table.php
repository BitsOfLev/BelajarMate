<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->string('location')->nullable()->after('sessionMode');
            $table->string('meeting_link')->nullable()->after('location');
        });
    }

    public function down()
    {
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->dropColumn(['location', 'meeting_link']);
        });
    }
};

