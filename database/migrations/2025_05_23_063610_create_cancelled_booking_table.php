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
        Schema::create('cancelled_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->text('cancel_reason');
            $table->unsignedBigInteger('cancel_by_user');
            $table->timestamps();

            $table->foreign('book_id')->references('book_id')->on('booking')->onDelete('cascade');
            $table->foreign('cancel_by_user')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_booking');
    }
};
