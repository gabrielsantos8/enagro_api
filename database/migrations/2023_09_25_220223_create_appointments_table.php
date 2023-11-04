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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activation_id');
            $table->foreign('activation_id')->references('id')->on('activations');
            $table->float('value');
            $table->timestamp('initial_date');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('appointment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
