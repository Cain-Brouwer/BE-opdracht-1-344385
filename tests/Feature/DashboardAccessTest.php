<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.index'))->assertRedirect(route('login'));
    }

    public function test_a_logged_in_user_sees_the_dashboard_with_their_roles(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee('user');
    }

    public function test_a_regular_user_cannot_open_the_admin_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('admin.index'))->assertForbidden();
    }

    public function test_an_admin_sees_all_users_with_their_roles(): void
    {
        $admin = User::factory()->create(['name' => 'Beheerder']);
        $admin->assignRole('admin');

        $other = User::factory()->create(['name' => 'Magazijnmedewerker']);
        $other->assignRole('magazijnmedewerker');

        $this->actingAs($admin)
            ->get(route('admin.index'))
            ->assertOk()
            ->assertSee('Beheerder')
            ->assertSee('Magazijnmedewerker')
            ->assertSee('admin');
    }

    public function test_a_user_without_any_role_still_sees_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('Admin Panel');
    }
}
