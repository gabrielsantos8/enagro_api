<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['complement', 'city_id', 'user_id'];

    public function users() {
        return $this->hasMany(User::class);
    }
}
