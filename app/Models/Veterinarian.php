<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinarian extends Model
{
    use HasFactory;

    protected $fillable = ['id_pf_inscricao','pf_inscricao','pf_uf','nome','nome_social','atuante','user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
