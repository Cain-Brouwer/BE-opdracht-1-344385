<?php

namespace Database\Factories;

use App\Models\Allergeen;
use App\Models\Product;
use App\Models\ProductPerAllergeen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPerAllergeen>
 */
class ProductPerAllergeenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ProductId' => Product::factory(),
            'AllergeenId' => Allergeen::factory(),
            'IsActief' => true,
            'Opmerking' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ];
    }
}
