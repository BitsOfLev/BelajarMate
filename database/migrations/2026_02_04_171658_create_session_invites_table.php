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
        Schema::create('session_invites', function (Blueprint $table) {
            $table->id('inviteID');
            $table->unsignedBigInteger('sessionID');
            $table->unsignedBigInteger('invitedUserID');
            $table->enum('invite_status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->timestamp('invited_at')->useCurrent();
            $table->timestamp('responded_at')->nullable();
            
            $table->foreign('sessionID')->references('sessionID')->on('study_sessions')->onDelete('cascade');
            $table->foreign('invitedUserID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_invites');
    }
};
