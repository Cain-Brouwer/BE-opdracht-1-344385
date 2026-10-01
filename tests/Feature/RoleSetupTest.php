<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * The roles and the accounts that use them must exist and be linked correctly,
 * because the warehouse screens are gated by the role magazijnmedewerker.
 */
class RoleSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_role_seeder_creates_the_three_roles(): void
    {
        $this->seed(RoleSeeder::class);

        $this->assertEqualsCanonicalizing(
            ['admin', 'magazijnmedewerker', 'user'],
            Role::query()->pluck('name')->all(),
        );
    }

    public function test_the_role_seeder_can_run_twice_without_duplicates(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(RoleSeeder::class);

        $this->assertSame(3, Role::query()->count());
    }

    public function test_every_seeded_account_gets_its_own_role(): void
    {
        $this->seed(DatabaseSeeder::class);

        $verwacht = [
            'admin@admin.com' => 'admin',
            'magazijnmedewerker@jamin.nl' => 'magazijnmedewerker',
            'test@example.com' => 'user',
        ];

        foreach ($verwacht as $email => $rol) {
            $user = User::query()->where('email', $email)->firstOrFail();

            $this->assertTrue($user->hasRole($rol), "{$email} heeft niet de rol {$rol}.");
            $this->assertSame([$rol], $user->roles->pluck('name')->all());
        }
    }

    public function test_every_seeded_account_can_log_in(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (['admin@admin.com', 'magazijnmedewerker@jamin.nl', 'test@example.com'] as $email) {
            $this->post(route('login'), [
                'email' => $email,
                'password' => 'wachtwoord',
            ])->assertRedirect(route('dashboard'));

            $this->post(route('logout'));
        }
    }

    public function test_the_seeded_password_is_stored_as_a_hash(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->where('email', 'magazijnmedewerker@jamin.nl')->firstOrFail();

        $this->assertNotSame('wachtwoord', $user->password);
        $this->assertTrue(Hash::check('wachtwoord', $user->password));
    }

    public function test_a_new_account_gets_the_user_role_even_without_the_role_seeder(): void
    {
        $this->assertSame(0, Role::query()->count());

        $this->post(route('register'), [
            'name' => 'Jan Jansen',
            'email' => 'jan@example.com',
            'password' => 'geheim-wachtwoord',
            'password_confirmation' => 'geheim-wachtwoord',
        ])->assertRedirect(route('dashboard'));

        $this->assertTrue(User::query()->where('email', 'jan@example.com')->firstOrFail()->hasRole('user'));
    }

    public function test_only_the_warehouse_role_reaches_the_overview(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->actingAs(User::query()->where('email', 'magazijnmedewerker@jamin.nl')->firstOrFail())
            ->get(route('magazijn.index'))->assertOk();

        $this->actingAs(User::query()->where('email', 'admin@admin.com')->firstOrFail())
            ->get(route('magazijn.index'))->assertOk();

        $this->actingAs(User::query()->where('email', 'test@example.com')->firstOrFail())
            ->get(route('magazijn.index'))->assertForbidden();
    }
}
