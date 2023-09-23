<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlanContractAnimal extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'animal_id'];
}
