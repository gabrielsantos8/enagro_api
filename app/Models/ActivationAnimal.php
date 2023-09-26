<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationAnimal extends Model
{
    use HasFactory;
    protected $fillable = ['activation_id', 'animal_id'];
}
