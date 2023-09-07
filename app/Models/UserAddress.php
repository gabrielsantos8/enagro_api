<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['complement', 'city_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function animals() {
        return $this->hasMany(Animal::class);
    }
}
