<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $table) {

            // Primary key
            $table->id('commentID');

            // Foreign key to blogs
            $table->unsignedInteger('blogID');
            $table->foreign('blogID')
                  ->references('blogID')
                  ->on('blogs')
                  ->cascadeOnDelete();

            // Foreign key to users
            $table->foreignId('userID')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Comment content
            $table->text('commentText');

            // Moderation fields
            $table->enum('status', ['approved','pending','rejected'])
                  ->default('approved');
            $table->text('flag_reason')->nullable();

            // Timestamps
            $table->timestamps();

            // Soft deletes
            $table->softDeletes();

            // Indexes for performance
            $table->index('status');
            $table->index('blogID');
            $table->index('userID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};

