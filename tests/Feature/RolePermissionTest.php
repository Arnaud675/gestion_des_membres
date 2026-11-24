<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_admin_can_change_a_user_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $manager = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($admin)->put(route('admin.users.role.update', $manager), [
            'role' => 'reader',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $manager->id, 'role' => 'reader']);
    }

    public function test_reader_cannot_manage_members(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);

        $response = $this->actingAs($reader)->get(route('members.create'));

        $response->assertRedirect(route('members.index'))
            ->assertSessionHas('error');
    }

    public function test_reader_cannot_open_user_role_management(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);

        $this->actingAs($reader)
            ->get(route('admin.users'))
            ->assertForbidden();
    }

    public function test_manager_can_still_manage_members(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);

        $this->actingAs($manager)
            ->get(route('members.create'))
            ->assertOk();
    }

    public function test_admin_can_open_user_role_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.users'))
            ->assertOk()
            ->assertViewIs('admin.users');
    }

    public function test_admin_can_reset_another_users_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $manager = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($admin)->put(route('admin.users.password.reset', $manager), [
            'password' => 'nouveau-mot-de-passe',
            'password_confirmation' => 'nouveau-mot-de-passe',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success');
        $this->assertTrue(Hash::check('nouveau-mot-de-passe', $manager->fresh()->password));
    }

    public function test_password_confirmation_must_match(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $manager = User::factory()->create(['role' => 'manager']);

        $response = $this->actingAs($admin)->from(route('admin.users'))->put(route('admin.users.password.reset', $manager), [
            'password' => 'nouveau-mot-de-passe',
            'password_confirmation' => 'mot-different',
        ]);

        $response->assertRedirect(route('admin.users'))
            ->assertSessionHasErrors('password');
    }

    public function test_admin_can_create_a_user_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Gestionnaire Test',
            'email' => 'gestionnaire@test.local',
            'role' => 'manager',
            'password' => 'mot-de-passe-test',
            'password_confirmation' => 'mot-de-passe-test',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => 'gestionnaire@test.local',
            'role' => 'manager',
        ]);
    }

    public function test_admin_cannot_create_duplicate_user_email(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['email' => 'double@test.local', 'role' => 'reader']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Utilisateur Double',
            'email' => 'double@test.local',
            'role' => 'reader',
            'password' => 'mot-de-passe-test',
            'password_confirmation' => 'mot-de-passe-test',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_delete_another_unreferenced_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $reader = User::factory()->create(['role' => 'reader']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $reader));

        $response->assertRedirect()
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $reader->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect()
            ->assertSessionHasErrors('delete');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_sidebar_admin_section_is_hidden_from_manager_and_reader(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $this->actingAs($manager)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Administration & Outils')
            ->assertDontSee('Sauvegarde')
            ->assertDontSee('Utilisateurs et rôles');

        $reader = User::factory()->create(['role' => 'reader']);
        $this->actingAs($reader)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Administration & Outils');
    }

    public function test_sidebar_admin_section_is_visible_to_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Administration & Outils')
            ->assertSee('Sauvegarde')
            ->assertSee('Utilisateurs et rôles');
    }
}
