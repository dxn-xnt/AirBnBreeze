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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('user_fname');
            $table->string('user_lname');
            $table->string('user_contact_number', 11)->unique(); // Limited to 11 characters
            $table->string('user_email')->unique();
            $table->string('user_password');
            $table->date('user_date_created');
            $table->string('user_profile')->nullable();
            $table->boolean('user_is_host')->default(false);
            // $table->text('user_about')->nullable(); // New about column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
