<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_likes', function (Blueprint $table) {

            $table->id('likeID');

            // Foreign keys
            $table->unsignedInteger('blogID');
            $table->foreign('blogID')
                  ->references('blogID')
                  ->on('blogs')
                  ->cascadeOnDelete();

            $table->foreignId('userID')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Optional: track when the like was made
            $table->timestamps();

            // Soft deletes if you want users to “unlike” without deleting the record permanently
            $table->softDeletes();

            // Prevent a user from liking the same blog twice
            $table->unique(['blogID','userID']);

            // Indexes
            $table->index('blogID');
            $table->index('userID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
    }
};

