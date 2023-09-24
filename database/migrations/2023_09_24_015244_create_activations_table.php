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
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('health_plan_contracts');
            $table->unsignedBigInteger('veterinarian_id');
            $table->foreign('veterinarian_id')->references('id')->on('veterinarians');
            $table->unsignedBigInteger('activation_status_id');
            $table->foreign('activation_status_id')->references('id')->on('activation_status');
            $table->unsignedBigInteger('activation_type_id');
            $table->foreign('activation_type_id')->references('id')->on('activation_types');
            $table->date('scheduled_date');
            $table->date('activation_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activations');
    }
};
