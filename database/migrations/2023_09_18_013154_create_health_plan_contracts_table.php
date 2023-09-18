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
        Schema::create('health_plan_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('health_plan_id');
            $table->foreign('health_plan_id')->references('id')->on('health_plans');
            $table->unsignedBigInteger('health_plan_contract_type_id');
            $table->foreign('health_plan_contract_type_id')->references('id')->on('health_plan_contract_types');
            $table->float('value');
            $table->unsignedBigInteger('health_plan_contract_status_id');
            $table->foreign('health_plan_contract_status_id')->references('id')->on('health_plan_contract_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_plan_contracts');
    }
};
