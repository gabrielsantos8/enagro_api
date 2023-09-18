<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanContract extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'health_plan_id', 'health_plan_contract_type_id', 'value', 'health_plan_contract_status_id'];
}
