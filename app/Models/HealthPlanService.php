<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanService extends Model
{
    use HasFactory;
    protected $fillable = ['health_plan_id','service_id'];
}
