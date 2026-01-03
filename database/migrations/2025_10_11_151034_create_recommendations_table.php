<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation', function (Blueprint $table) {
            $table->id('recommendationID'); // PK
            $table->unsignedBigInteger('userID'); // The user who receives the recommendation
            $table->unsignedBigInteger('recommendedUserID'); // The recommended study partner
            $table->float('score')->nullable(); // Compatibility score
            $table->json('factors')->nullable(); // Matching details (JSON)
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('userID')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('recommendedUserID')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation');
    }
};
