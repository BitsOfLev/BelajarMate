<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id('connectionID'); // primary key
            $table->unsignedBigInteger('requesterID');
            $table->unsignedBigInteger('receiverID');
            $table->enum('connection_status', ['pending', 'accepted', 'rejected', 'blocked'])->default('pending');
            $table->timestamps();

            // foreign keys (optional if you want constraints)
            $table->foreign('requesterID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiverID')->references('id')->on('users')->onDelete('cascade');

            // prevent duplicate request rows in same direction
            $table->unique(['requesterID', 'receiverID']);
            // index to quickly search relationships both ways
            $table->index(['receiverID', 'requesterID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('connections');
    }
};

