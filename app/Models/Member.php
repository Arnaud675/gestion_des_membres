<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
