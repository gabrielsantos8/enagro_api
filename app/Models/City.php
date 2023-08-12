<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'uf', 'ibge'];

    public function userAddress(){
        return $this->hasMany(UserAddress::class);
    }
}
