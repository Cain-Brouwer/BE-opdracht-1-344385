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

        $klant = User::updateOrCreate(
            ['email' => 'klant@jamin.nl'],
            [
                'name' => 'Klant',
                'password' => $password,
            ],
        );
        $klant->syncRoles(['klant']);

        $warehouseEmployee = User::updateOrCreate(
            ['email' => 'magazijnmedewerker@jamin.nl'],
            [
                'name' => 'Magazijnmedewerker',
                'password' => $password,
            ],
        );
        $warehouseEmployee->syncRoles(['magazijnmedewerker']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => $password,
            ],
        );
        $admin->syncRoles(['admin']);
    }
}
