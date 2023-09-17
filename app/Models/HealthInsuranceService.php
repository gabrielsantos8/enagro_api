<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInsuranceService extends Model
{
    use HasFactory;
    protected $fillable = ['health_insurance_id','service_id'];
}
