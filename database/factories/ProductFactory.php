<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Naam' => fake()->unique()->words(2, true),
            'Barcode' => fake()->unique()->numerify('8719587######'),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }

    public function inactief(): static
    {
        return $this->state(fn (array $attributes) => [
            'IsActief' => false,
        ]);
    }
}
