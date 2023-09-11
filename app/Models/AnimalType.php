<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function animals() {
        return $this->hasMany(Animal::class);
    }

    public function animalSubtypes() {
        return $this->hasMany(AnimalSubtype::class);
    }
}
