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
        Schema::create('notification', function (Blueprint $table) {
            $table->id('notif_id');
            $table->string('notif_type');
            $table->text('notif_message');
            $table->boolean('notif_is_read')->default(false);
            $table->unsignedBigInteger('notif_sender_id');
            $table->unsignedBigInteger('notif_receiver_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('prop_id');

            $table->timestamps();
            $table->foreign('book_id')->references('book_id')->on('booking')->onDelete('cascade');
            $table->foreign('prop_id')->references('prop_id')->on('property')->onDelete('cascade');
            $table->foreign('notif_sender_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('notif_receiver_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
