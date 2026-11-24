<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Cotisation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MemberManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_user_can_create_a_member_with_selected_nationality_and_profession(): void
    {
        $user = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($user)->post(route('members.store'), $this->memberData([
            'nationalite' => 'Togolaise',
            'profession' => 'Transitaire',
        ]));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', [
            'numero_membre' => 'MBR-TEST-001',
            'nationalite' => 'Togolaise',
            'profession' => 'Transitaire',
        ]);
    }

    public function test_member_creation_is_recorded_in_audit_history(): void
    {
        $user = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($user)->post(route('members.store'), $this->memberData([
            'nationalite' => 'Togolaise',
            'profession' => 'Transitaire',
        ]));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'created',
            'subject_type' => 'App\\Models\\Member',
        ]);
    }

    public function test_edit_form_shows_and_selects_member_options(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = Member::create($this->memberData([
            'nationalite' => 'Togolaise',
            'profession' => 'Transitaire',
        ]));

        $response = $this->actingAs($user)->get(route('members.edit', $member));

        $response->assertOk()
            ->assertSee('value="Togolaise" selected', false)
            ->assertSee('value="Transitaire" selected', false);
    }

    public function test_member_listing_is_paginated_and_keeps_search_query(): void
    {
        $user = User::factory()->create(['role' => 'manager']);

        foreach (range(1, 16) as $number) {
            Member::create($this->memberData([
                'numero_membre' => sprintf('MBR-TEST-%03d', $number),
                'nom' => 'Member',
                'prenoms' => sprintf('Person %02d', $number),
            ]));
        }

        $response = $this->actingAs($user)->get(route('members.index', ['search' => 'Member']));

        $response->assertOk()
            ->assertSee('Member')
            ->assertSee('search=Member', false);
        $this->assertSame(16, $response->viewData('members')->total());
        $this->assertSame(15, $response->viewData('members')->perPage());
    }

    public function test_member_listing_returns_html_fragments_for_ajax_requests(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        Member::create($this->memberData());

        $response = $this->actingAs($user)
            ->getJson(route('members.index', ['search' => 'Doe']));

        $response->assertOk()
            ->assertJsonStructure(['rows', 'pagination'])
            ->assertJsonPath('rows', fn (string $rows) => str_contains($rows, 'Doe Jane'));
    }

    public function test_user_can_update_a_member(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = Member::create($this->memberData());

        $response = $this->actingAs($user)->put(route('members.update', $member), $this->memberData([
            'numero_membre' => 'MBR-TEST-002',
            'nom' => 'Updated',
            'profession' => 'Transitaire',
        ]));

        $response->assertRedirect(route('members.show', $member));
        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'numero_membre' => 'MBR-TEST-002',
            'nom' => 'Updated',
            'profession' => 'Transitaire',
        ]);
    }

    public function test_user_can_delete_a_member_without_cotisations(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = Member::create($this->memberData());

        $response = $this->actingAs($user)->delete(route('members.destroy', $member));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_member_with_cotisations_cannot_be_deleted(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = Member::create($this->memberData());
        Cotisation::create([
            'member_id' => $member->id,
            'mois' => 1,
            'annee' => 2026,
            'montant' => 100,
            'date_paiement' => '2026-01-10',
        ]);

        $response = $this->actingAs($user)->delete(route('members.destroy', $member));

        $response->assertRedirect(route('members.index'))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('members', ['id' => $member->id]);
    }

    public function test_manager_can_archive_and_restore_member(): void
    {
        $user = User::factory()->create(['role' => 'manager']);
        $member = Member::create($this->memberData());

        $archiveResponse = $this->actingAs($user)->post(route('members.archive', $member));

        $archiveResponse->assertRedirect(route('members.index'));
        $this->assertNotNull($member->fresh()->archived_at);

        $this->actingAs($user)
            ->get(route('members.archived'))
            ->assertOk()
            ->assertSee('Doe Jane');

        $restoreResponse = $this->actingAs($user)->post(route('members.restore', $member));

        $restoreResponse->assertRedirect(route('members.archived'));
        $this->assertNull($member->fresh()->archived_at);
        $this->assertDatabaseHas('members', ['id' => $member->id, 'nom' => 'Doe']);
    }

    public function test_manager_can_export_active_members_as_csv(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        Member::create($this->memberData(['numero_membre' => 'MBR-CSV-001']));

        $response = $this->actingAs($manager)->get(route('members.export.csv'));

        $response->assertOk();
        $response->assertDownload();
        $this->assertStringContainsString('numero_membre', $response->streamedContent());
        $this->assertStringContainsString('MBR-CSV-001', $response->streamedContent());
    }

    public function test_manager_can_import_members_and_duplicate_is_ignored(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        Member::create($this->memberData(['numero_membre' => 'MBR-DUP-001', 'nom' => 'Existant']));

        $csv = implode("\n", [
            'numero_membre;nom;prenoms;date_naissance;lieu_naissance;profession',
            'MBR-DUP-001;Existant;Test;1990-01-01;Lomé;Testeur',
            'MBR-CSV-002;Nouveau;Membre;1995-05-10;Kara;Ingénieur',
        ]);

        $file = UploadedFile::fake()->createWithContent('membres.csv', $csv);

        $response = $this->actingAs($manager)->post(route('members.import.csv'), [
            'csv_file' => $file,
        ]);

        $response->assertRedirect(route('members.import.form'));
        $this->assertDatabaseHas('members', [
            'numero_membre' => 'MBR-CSV-002',
            'nom' => 'Nouveau',
        ]);
        $this->assertDatabaseMissing('members', [
            'numero_membre' => 'MBR-DUP-001',
            'nom' => 'Nouveau',
        ]);
    }

    public function test_csv_import_requires_member_headers(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $file = UploadedFile::fake()->createWithContent(
            'membres.csv',
            "nom;prenoms\nDoe;Jane\n"
        );

        $response = $this->actingAs($manager)->post(route('members.import.csv'), [
            'csv_file' => $file,
        ]);

        $response->assertSessionHasErrors('csv_file');
    }

    private function memberData(array $overrides = []): array
    {
        return array_merge([
            'numero_membre' => 'MBR-TEST-001',
            'nom' => 'Doe',
            'prenoms' => 'Jane',
            'date_naissance' => '1990-05-10',
            'lieu_naissance' => 'Lomé',
            'nationalite' => null,
            'profession' => null,
        ], $overrides);
    }
}