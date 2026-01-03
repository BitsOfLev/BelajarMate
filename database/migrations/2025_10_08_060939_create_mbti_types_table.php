<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mbti_types', function (Blueprint $table) {
            $table->id('mbtiID'); // PK
            $table->string('mbti')->unique(); // e.g., INFP, ESTJ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mbti_types');
    }
};

