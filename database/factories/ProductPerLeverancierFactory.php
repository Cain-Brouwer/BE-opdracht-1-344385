<?php

namespace Database\Factories;

use App\Models\Leverancier;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPerLeverancier>
 */
class ProductPerLeverancierFactory extends Factory
{
    public function definition(): array
    {
        $datumLevering = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'LeverancierId' => Leverancier::factory(),
            'ProductId' => Product::factory(),
            'DatumLevering' => $datumLevering,
            'Aantal' => fake()->numberBetween(1, 100),
            'DatumEerstVolgendeLevering' => (clone $datumLevering)->modify('+1 week'),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }

    public function zonderVolgendeLevering(): static
    {
        return $this->state(fn (array $attributes) => [
            'DatumEerstVolgendeLevering' => null,
        ]);
    }
}
