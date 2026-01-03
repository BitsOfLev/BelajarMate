<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_reports', function (Blueprint $table) {

            $table->id('reportID');

            // User who made the report
            $table->foreignId('userID')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Reported blog or comment
            $table->unsignedInteger('blogID')->nullable();
            $table->foreign('blogID')
                  ->references('blogID')
                  ->on('blogs')
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('commentID')->nullable();
            $table->foreign('commentID')
                  ->references('commentID')
                  ->on('blog_comments')
                  ->cascadeOnDelete();

            // Reason for reporting
            $table->text('report_reason');

            // Status of report
            $table->enum('status', ['pending','reviewed','dismissed'])
                  ->default('pending');

            // Optional notes from admin
            $table->text('admin_notes')->nullable();

            // Timestamps
            $table->timestamps();

            // Soft deletes
            $table->softDeletes();

            // Indexes
            $table->index('userID');
            $table->index('blogID');
            $table->index('commentID');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_reports');
    }
};

