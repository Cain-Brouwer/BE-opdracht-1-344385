<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_the_login_screen_can_be_rendered(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_a_visitor_can_register_and_gets_the_user_role(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Jan Jansen',
            'email' => 'jan@example.com',
            'password' => 'geheim-wachtwoord',
            'password_confirmation' => 'geheim-wachtwoord',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'jan@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('klant'));
        $this->assertTrue(Hash::check('geheim-wachtwoord', $user->password));
    }

    public function test_registering_with_an_existing_email_fails(): void
    {
        User::factory()->create(['email' => 'jan@example.com']);

        $this->post(route('register'), [
            'name' => 'Jan Jansen',
            'email' => 'jan@example.com',
            'password' => 'geheim-wachtwoord',
            'password_confirmation' => 'geheim-wachtwoord',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_user_can_log_in_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'geheim-wachtwoord']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'geheim-wachtwoord',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_logging_in_with_a_wrong_password_fails(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'fout-wachtwoord',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
