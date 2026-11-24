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
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class); // Laravel utilise member_id automatiquement
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function archive(): bool
    {
        return $this->update(['archived_at' => now()]);
    }

    public function restore(): bool
    {
        return $this->update(['archived_at' => null]);
    }
}
