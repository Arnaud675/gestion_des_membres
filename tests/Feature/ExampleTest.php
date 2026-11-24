<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_dashboard_is_available_to_all_authenticated_roles(): void
    {
        $middleware = Route::getRoutes()->getByName('admin.dashboard')->gatherMiddleware();

        $this->assertContains('auth', $middleware);
        $this->assertNotContains('can:admin', $middleware);
    }

    public function test_admin_can_open_creation_forms(): void
    {
        $admin = new User([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/members/create')
            ->assertOk();

        $this->get('/cotisations/create')->assertOk();
        $this->get('/depenses/create')->assertOk();
    }

    public function test_financial_routes_require_authentication(): void
    {
        $this->get('/depenses')->assertRedirect('/login');
        $this->get('/depenses/create')->assertRedirect('/login');
        $this->get('/members/1/cotisations')->assertRedirect('/login');
    }

    public function test_login_post_is_rate_limited(): void
    {
        $middleware = Route::getRoutes()->match(\Illuminate\Http\Request::create('/login', 'POST'))->gatherMiddleware();

        $this->assertContains('throttle:5,1', $middleware);
    }

}
