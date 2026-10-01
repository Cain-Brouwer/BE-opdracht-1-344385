<?php

namespace Database\Factories;

use App\Models\Magazijn;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Magazijn>
 */
class MagazijnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ProductId' => Product::factory(),
            'Verpakkingseenheid' => fake()->randomFloat(2, 1, 10),
            'AantalAanwezig' => fake()->numberBetween(1, 800),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }

    public function zonderVoorraad(): static
    {
        return $this->state(fn (array $attributes) => [
            'AantalAanwezig' => null,
        ]);
    }
}
