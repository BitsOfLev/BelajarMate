<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('note_resources', function (Blueprint $table) {
            $table->id(); // Creates 'id' as primary key
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->enum('resource_type', ['link', 'file']);
            $table->string('resource_link', 500)->nullable(); // For URLs
            $table->string('resource_file_path')->nullable(); // For uploaded files
            $table->string('resource_name')->nullable(); // Display name
            $table->timestamps(); // Creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_resources');
    }
};
