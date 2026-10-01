<?php

namespace Database\Factories;

use App\Models\Leverancier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leverancier>
 */
class LeverancierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Naam' => fake()->company(),
            'ContactPersoon' => fake()->name(),
            'LeverancierNummer' => fake()->unique()->bothify('L#########'),
            'Mobiel' => fake()->numerify('06-########'),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }
}
