<?php

namespace Tests\Feature;

use App\Models\Caisse;
use App\Models\Cotisation;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GestionDesMembresTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    private function member(array $attributes = []): Member
    {
        return Member::create(array_merge([
            'numero_membre' => '001',
            'nom' => 'Test',
            'prenoms' => 'Test',
            'date_naissance' => '2000-01-01',
            'lieu_naissance' => 'Lomé',
        ], $attributes));
    }

    public function test_les_depenses_exigent_une_authentification(): void
    {
        $this->get('/depenses')->assertRedirect('/login');
        $this->get('/depenses/create')->assertRedirect('/login');
    }

    public function test_les_formulaires_membres_s_affichent(): void
    {
        $user = $this->user();
        $member = $this->member();

        $this->actingAs($user)->get('/depenses')->assertOk();
        $this->actingAs($user)->get('/members/create')
            ->assertOk()
            ->assertSee('name="numero_membre"', false);
        $this->actingAs($user)->get("/members/{$member->id}/edit")
            ->assertOk()
            ->assertSee('value="001"', false);
    }

    public function test_le_cycle_de_vie_d_une_cotisation_synchronise_la_caisse(): void
    {
        $user = $this->user();
        $member = $this->member();

        $this->actingAs($user)->post('/cotisations', [
            'member_id' => $member->id,
            'mois' => 1,
            'annee' => 2026,
            'montant' => 1000,
            'date_paiement' => '2026-01-05',
        ])->assertRedirect('/cotisations');

        $cotisation = Cotisation::firstOrFail();
        $this->assertEquals(1000, Caisse::getSoldeGlobal());

        $this->actingAs($user)->put("/cotisations/{$cotisation->id}", [
            'mois' => 1,
            'annee' => 2026,
            'montant' => 500,
            'date_paiement' => '2026-01-05',
        ])->assertRedirect('/cotisations');

        $this->assertEquals(500, Caisse::getSoldeGlobal());

        $this->actingAs($user)->delete("/cotisations/{$cotisation->id}");

        $this->assertEquals(0, Caisse::getSoldeGlobal());
        $this->assertDatabaseMissing('cotisations', ['id' => $cotisation->id]);
    }

    public function test_la_suppression_d_un_membre_retire_ses_cotisations_de_la_caisse(): void
    {
        $user = $this->user();
        $member = $this->member();

        Cotisation::create([
            'member_id' => $member->id,
            'mois' => 2,
            'annee' => 2026,
            'montant' => 1000,
            'date_paiement' => '2026-02-05',
        ]);
        Caisse::ajouterMontant(1000);

        $this->actingAs($user)->delete("/members/{$member->id}")
            ->assertRedirect('/members');

        $this->assertEquals(0, Caisse::getSoldeGlobal());
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
        $this->assertDatabaseMissing('cotisations', ['member_id' => $member->id]);
    }

    public function test_la_modification_d_un_membre_valide_le_numero_unique(): void
    {
        $user = $this->user();
        $first = $this->member(['numero_membre' => '001']);
        $second = $this->member(['numero_membre' => '002']);

        $payload = [
            'numero_membre' => '002',
            'nom' => 'Test',
            'prenoms' => 'Test',
            'date_naissance' => '2000-01-01',
            'lieu_naissance' => 'Lomé',
        ];

        $this->actingAs($user)->put("/members/{$first->id}", $payload)
            ->assertSessionHasErrors('numero_membre');

        $this->assertDatabaseHas('members', [
            'id' => $first->id,
            'numero_membre' => '001',
        ]);

        $payload['numero_membre'] = '001';

        $this->actingAs($user)->put("/members/{$first->id}", $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect("/members/{$first->id}");

        $this->assertDatabaseHas('members', [
            'id' => $second->id,
            'numero_membre' => '002',
        ]);
    }
}
