<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalSubtype extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'animal_type_id'];

    public function animalType() {
        return $this->belongsTo(AnimaType::class);
    }

}
