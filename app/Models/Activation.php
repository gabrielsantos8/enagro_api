<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'veterinarian_id', 'activation_status_id', 'activation_type_id', 'scheduled_date', 'activation_date'];
}
