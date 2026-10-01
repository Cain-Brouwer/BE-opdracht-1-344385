<?php

namespace Database\Factories;

use App\Models\Allergeen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Allergeen>
 */
class AllergeenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Naam' => fake()->unique()->word(),
            'Omschrijving' => 'Dit product bevat '.fake()->word(),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }
}
