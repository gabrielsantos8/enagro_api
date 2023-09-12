<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'animal_type_id', 'img_url', 'user_address_id', 'birth_date', 'animal_subtype_id', 'weight'];

    public function userAddress() {
        return $this->belongsTo(UserAddress::class);
    }
}
