<?php
// app/Models/Caisse.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = ['solde_global'];

    protected $casts = [
        'solde_global' => 'decimal:2'
    ];

    /**
     * Récupère le solde global actuel
     */
    public static function getSoldeGlobal(): float
    {
        $caisse = self::first();
        return $caisse ? $caisse->solde_global : 0;
    }

    /**
     * Ajoute un montant au solde global
     */
    public static function ajouterMontant(float $montant): bool
    {
        $caisse = self::first();
        if (!$caisse) {
            $caisse = self::create(['solde_global' => 0]);
        }
        $caisse->solde_global += $montant;
        return $caisse->save();
    }

    /**
     * Retire un montant du solde global
     */
    public static function retirerMontant(float $montant): bool
    {
        $caisse = self::first();
        if (!$caisse) {
            return false;
        }
        
        if ($caisse->solde_global < $montant) {
            return false;
        }
        
        $caisse->solde_global -= $montant;
        return $caisse->save();
    }

    /**
     * Vérifie si le solde est suffisant
     */
    public static function aSoldeSuffisant(float $montant): bool
    {
        return self::getSoldeGlobal() >= $montant;
    }
}