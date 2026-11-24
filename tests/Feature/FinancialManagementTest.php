<?php

namespace Tests\Feature;

use App\Models\Caisse;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class FinancialManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_cotisation_lifecycle_keeps_cash_balance_consistent(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = $this->createMember();
        $caisse = Caisse::firstOrFail();

        $createResponse = $this->actingAs($user)->post(route('cotisations.store'), [
            'member_id' => $member->id,
            'mois' => 1,
            'annee' => 2026,
            'montant' => 400,
            'date_paiement' => '2026-01-10',
        ]);

        $createResponse->assertRedirect(route('cotisations.index'));
        $cotisation = Cotisation::firstOrFail();
        $this->assertSame(400.0, (float) $caisse->fresh()->solde_global);

        $updateResponse = $this->put(route('cotisations.update', $cotisation), [
            'mois' => 2,
            'annee' => 2026,
            'montant' => 600,
            'date_paiement' => '2026-02-10',
        ]);

        $updateResponse->assertRedirect(route('cotisations.index'));
        $this->assertDatabaseHas('cotisations', [
            'id' => $cotisation->id,
            'mois' => 2,
            'montant' => 600,
        ]);
        $this->assertSame(600.0, (float) $caisse->fresh()->solde_global);

        $decreaseResponse = $this->put(route('cotisations.update', $cotisation), [
            'mois' => 3,
            'annee' => 2026,
            'montant' => 300,
            'date_paiement' => '2026-03-10',
        ]);

        $decreaseResponse->assertRedirect(route('cotisations.index'));
        $this->assertSame(300.0, (float) $caisse->fresh()->solde_global);

        $deleteResponse = $this->delete(route('cotisations.destroy', $cotisation));

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('cotisations', ['id' => $cotisation->id]);
        $this->assertSame(0.0, (float) $caisse->fresh()->solde_global);
    }

    public function test_depense_lifecycle_keeps_cash_balance_consistent(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = $this->createMember();
        $caisse = Caisse::firstOrFail();
        $caisse->update(['solde_global' => 2000]);

        $createResponse = $this->actingAs($user)->post(route('depenses.store'), [
            'member_id' => $member->id,
            'type_evenement' => 'aide_sociale',
            'montant' => 500,
            'date_depense' => now()->toDateString(),
            'description' => 'Aide au membre',
        ]);

        $depense = Depense::firstOrFail();
        $createResponse->assertRedirect(route('depenses.show', $depense));
        $this->assertSame(1500.0, (float) $caisse->fresh()->solde_global);

        $updateResponse = $this->put(route('depenses.update', $depense), [
            'type_evenement' => 'urgence_medicale',
            'montant' => 700,
            'date_depense' => now()->toDateString(),
            'description' => 'Aide médicale',
        ]);

        $updateResponse->assertRedirect(route('depenses.show', $depense));
        $this->assertDatabaseHas('depenses', [
            'id' => $depense->id,
            'type_evenement' => 'urgence_medicale',
            'montant' => 700,
        ]);
        $this->assertSame(1300.0, (float) $caisse->fresh()->solde_global);

        $deleteResponse = $this->delete(route('depenses.destroy', $depense));

        $deleteResponse->assertRedirect(route('depenses.index'));
        $this->assertDatabaseMissing('depenses', ['id' => $depense->id]);
        $this->assertSame(2000.0, (float) $caisse->fresh()->solde_global);
    }

    public function test_members_are_flagged_as_late_for_unpaid_month(): void
    {
        $user = User::factory()->create(['role' => 'manager']);

        $paidMember = $this->createMember();
        $lateMember = Member::create([
            'numero_membre' => 'MBR-LATE-001',
            'nom' => 'Late',
            'prenoms' => 'Member',
            'date_naissance' => '1992-04-12',
            'lieu_naissance' => 'Lomé',
        ]);

        Cotisation::create([
            'member_id' => $paidMember->id,
            'mois' => 2,
            'annee' => 2026,
            'montant' => 500,
            'date_paiement' => '2026-02-10',
        ]);

        $response = $this->actingAs($user)->get(route('cotisations.retards', [
            'mois' => 2,
            'annee' => 2026,
        ]));

        $response->assertOk()
            ->assertSee('Late Member')
            ->assertDontSee('Doe Jane')
            ->assertSee('En retard');

        $this->assertSame(1, $response->viewData('retardsCount'));
    }

    private function createMember(): Member
    {
        return Member::create([
            'numero_membre' => 'MBR-FIN-' . fake()->unique()->numerify('####'),
            'nom' => 'Doe',
            'prenoms' => 'Jane',
            'date_naissance' => '1990-05-10',
            'lieu_naissance' => 'Lomé',
        ]);
    }
}