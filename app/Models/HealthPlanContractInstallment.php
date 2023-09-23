<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanContractInstallment extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'installment_number', 'due_date', 'value', 'status_id'];
}
