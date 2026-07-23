<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_membre',
        'nom',
        'prenoms',
        'date_naissance',
        'lieu_naissance',
        'nom_pere',
        'nom_mere',
        'profession',
        'nationalite',
        'situation_matrimoniale',
        'adresse',
        'photo',
    ];

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class); // Laravel utilise member_id automatiquement
    }
}
