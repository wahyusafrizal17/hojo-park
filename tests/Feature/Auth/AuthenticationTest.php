<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleAndUserSeeder;
use Database\Seeders\SystemSettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoleAndUserSeeder::class,
            SystemSettingSeeder::class,
        ]);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login')
            ->assertDontSee('name="email"', false);
    }

    public function test_security_can_authenticate_with_access_password(): void
    {
        $component = Volt::test('pages.auth.login')
            ->set('form.password', 'security123');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isSecurity());
    }

    public function test_administrator_can_authenticate_with_access_password(): void
    {
        $component = Volt::test('pages.auth.login')
            ->set('form.password', 'admin123');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isAdministrator());
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $component = Volt::test('pages.auth.login')
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_security_cannot_access_history(): void
    {
        $user = User::query()->role(User::ROLE_SECURITY)->first();

        $this->actingAs($user)
            ->get('/parking/history')
            ->assertForbidden();
    }

    public function test_administrator_can_access_history(): void
    {
        $user = User::query()->role(User::ROLE_ADMINISTRATOR)->first();

        $this->actingAs($user)
            ->get('/parking/history')
            ->assertOk();
    }

    public function test_navigation_menu_can_be_rendered(): void
    {
        $user = User::query()->role(User::ROLE_SECURITY)->first();

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response
            ->assertOk()
            ->assertSeeLivewire(\App\Livewire\Dashboard\Overview::class);
    }

    public function test_users_can_logout(): void
    {
        $user = User::query()->role(User::ROLE_SECURITY)->first();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
