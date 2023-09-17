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
        Schema::create('health_insurances', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->text('detailed_description');
            $table->float('value');
            $table->integer('minimal_animals');
            $table->integer('maximum_animals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_insurances');
    }
};
