<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $password = Hash::make('wachtwoord');

        $testUser = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => $password,
            ],
        );
        $testUser->syncRoles(['user']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => $password,
            ],
        );
        $admin->syncRoles(['admin']);

        $warehouseEmployee = User::updateOrCreate(
            ['email' => 'magazijnmedewerker@jamin.nl'],
            [
                'name' => 'Magazijnmedewerker',
                'password' => $password,
            ],
        );
        $warehouseEmployee->syncRoles(['magazijnmedewerker']);
    }
}
