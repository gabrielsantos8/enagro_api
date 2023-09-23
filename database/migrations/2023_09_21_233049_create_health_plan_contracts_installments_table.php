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
        Schema::create('health_plan_contracts_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('health_plan_contracts');
            $table->integer('installment_number');
            $table->date('due_date');
            $table->float('value');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('health_plan_contracts_installments_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_plan_contracts_installments');
    }
};
