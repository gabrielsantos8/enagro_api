<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlan extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'detailed_description', 'value', 'minimal_animals', 'maximum_animals', 'plan_colors'];
}
