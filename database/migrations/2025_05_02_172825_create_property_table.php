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
        Schema::create('property', function (Blueprint $table) {
            $table->id('prop_id');
            $table->string('prop_type');
            $table->string('prop_title');
            $table->text('prop_description');
            $table->decimal('prop_price_per_night', 10, 2);
            $table->integer('prop_max_guest');
            $table->integer('prop_room_count');
            $table->integer('prop_bathroom_count');
            $table->string('prop_status');
            $table->text('prop_address');
            $table->timestamp('prop_date_created')->useCurrent();

            // Correct foreign key reference to match your users table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property');
    }
};
