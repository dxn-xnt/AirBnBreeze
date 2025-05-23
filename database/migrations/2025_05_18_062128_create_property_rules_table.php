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
        Schema::create('property_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('prop_id')->primary();
            $table->time('rule_check_in')->nullable();
            $table->time('rule_check_out')->nullable();
            $table->boolean('rule_no_smoking')->default(false);
            $table->boolean('rule_no_pet')->default(false);
            $table->boolean('rule_no_events')->default(false);
            $table->boolean('rule_security_cam')->default(false);
            $table->boolean('rule_alarm')->default(false);
            $table->boolean('rule_stairs')->default(false);
            $table->boolean('rule_cancellation')->default(false);
            $table->tinyInteger('rule_cancellation_rate')->nullable();

            $table->timestamps();
            $table->foreign('prop_id')->references('prop_id')->on('property')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rules');
    }
};
