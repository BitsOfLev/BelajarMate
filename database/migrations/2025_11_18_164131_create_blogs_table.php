<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('blogID');
            $table->unsignedBigInteger('userID');
            $table->unsignedInteger('categoryID');
            $table->string('blogTitle');
            $table->text('blogContent');
            $table->string('blogImg')->nullable();
            $table->dateTime('posted_at');

            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('categoryID')->references('categoryID')->on('blog_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
