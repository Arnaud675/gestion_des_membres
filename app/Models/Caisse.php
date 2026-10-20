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
     * Récupère le solde en verrouillant la ligne (à appeler dans une transaction).
     */
    public static function soldeVerrouille(): float
    {
        $caisse = self::query()->lockForUpdate()->first();
        return $caisse ? (float) $caisse->solde_global : 0;
    }

    /**
     * Ajoute un montant au solde global.
     * À appeler dans une transaction : le verrou protège la ligne jusqu'au commit.
     */
    public static function ajouterMontant(float $montant): bool
    {
        $caisse = self::query()->lockForUpdate()->first();
        if (!$caisse) {
            $caisse = self::create(['solde_global' => 0]);
        }
        $caisse->solde_global = (float) $caisse->solde_global + $montant;
        return $caisse->save();
    }

    /**
     * Retire un montant du solde global.
     * À appeler dans une transaction : le verrou protège la ligne jusqu'au commit.
     */
    public static function retirerMontant(float $montant): bool
    {
        $caisse = self::query()->lockForUpdate()->first();
        if (!$caisse) {
            return false;
        }

        if ((float) $caisse->solde_global < $montant) {
            return false;
        }

        $caisse->solde_global = (float) $caisse->solde_global - $montant;
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