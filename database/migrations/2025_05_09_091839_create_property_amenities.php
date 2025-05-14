<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('property_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prop_id'); // Foreign key to properties table
            $table->unsignedBigInteger('amn_id'); // Nullable for custom amenities
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('prop_id')->references('prop_id')->on('property')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_amenities');
    }
};
