<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class DatabaseBackupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_admin_can_open_backup_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.backup.index'))
            ->assertOk()
            ->assertViewIs('admin.backups');
    }

    public function test_manager_cannot_open_backup_page(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);

        $this->actingAs($manager)
            ->get(route('admin.backup.index'))
            ->assertForbidden();
    }

    public function test_restore_requires_exact_confirmation_word(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.backup.restore'), [
                'backup' => 'test.sql',
                'confirmation' => 'restaurer',
            ])
            ->assertSessionHasErrors('confirmation');
    }
}
