<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanContractsInstallments extends Model
{
    use HasFactory;
    protected $fillable = ['health_plan_contracts_id', 'installment_number', 'due_date', 'value', 'health_plan_contracts_installments_status_id'];
}
