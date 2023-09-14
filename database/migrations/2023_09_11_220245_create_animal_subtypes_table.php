<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_subtypes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('animal_type_id');
            $table->foreign('animal_type_id')->references('id')->on('animal_types');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_subtypes');
    }
};
