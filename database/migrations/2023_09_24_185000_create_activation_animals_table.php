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
        Schema::create('activation_animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activation_id');
            $table->foreign('activation_id')->references('id')->on('activations');
            $table->unsignedBigInteger('animal_id');
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activation_animals');
    }
};
