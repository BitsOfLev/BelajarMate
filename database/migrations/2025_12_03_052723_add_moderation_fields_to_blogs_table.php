<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {

            // Moderation fields
            $table->enum('status', ['approved','pending','rejected'])
                  ->default('approved')
                  ->after('blogImg');

            $table->text('flag_reason')
                  ->nullable()
                  ->after('status');

            // Soft Delete
            $table->softDeletes()->after('posted_at');

            // Timestamps (only if your table doesn't already have them)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {

            $table->dropColumn([
                'status',
                'flag_reason',
                'deleted_at',
                'created_at',
                'updated_at'
            ]);
        });
    }
};
