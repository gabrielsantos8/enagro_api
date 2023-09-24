<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationService extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'activation_id'];
}
