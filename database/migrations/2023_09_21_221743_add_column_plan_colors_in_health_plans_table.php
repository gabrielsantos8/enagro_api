<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('health_plans', function (Blueprint $table) {
            $table->text('plan_colors');
        });
    }

    public function down(): void
    {
        Schema::table('health_plans', function (Blueprint $table) {
            //
        });
    }
};
