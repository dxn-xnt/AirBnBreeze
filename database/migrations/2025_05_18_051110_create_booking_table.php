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
        Schema::create('booking', function (Blueprint $table) {
            $table->id('book_id');
            $table->date('book_check_in');
            $table->date('book_check_out');
            $table->decimal('book_total_price', 10, 2);
            $table->string('book_status')->default('pending');
            $table->timestamp('book_date_created')->useCurrent();
            $table->text('book_notes')->nullable();
            $table->integer('book_adult_count');
            $table->integer('book_child_count');

            $table->unsignedBigInteger('prop_id');
            $table->unsignedBigInteger('user_guest_id');

            // Fix foreign key references
            $table->foreign('prop_id')->references('prop_id')->on('property')->onDelete('cascade');
            $table->foreign('user_guest_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
