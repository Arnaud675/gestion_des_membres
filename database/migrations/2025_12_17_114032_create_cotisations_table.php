<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers members (anglais)
            $table->foreignId('member_id')
                ->constrained()  // automatiquement "members"
                ->onDelete('cascade');

            $table->tinyInteger('mois');   // 1 - 12
            $table->year('annee');
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');

            // Empêche doublons sur le même mois et membre
            $table->unique(['member_id', 'mois', 'annee']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
