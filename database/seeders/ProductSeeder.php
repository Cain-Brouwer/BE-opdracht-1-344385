<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Naam' => 'Mintnopjes', 'Barcode' => '8719587231278'],
            ['Naam' => 'Schoolkrijt', 'Barcode' => '8719587326713'],
            ['Naam' => 'Honingdrop', 'Barcode' => '8719587327836'],
            ['Naam' => 'Zure Beren', 'Barcode' => '8719587321441'],
            ['Naam' => 'Cola Flesjes', 'Barcode' => '8719587321237'],
            ['Naam' => 'Turtles', 'Barcode' => '8719587322245'],
            ['Naam' => 'Witte Muizen', 'Barcode' => '8719587328256'],
            ['Naam' => 'Reuzen Slangen', 'Barcode' => '8719587325641'],
            ['Naam' => 'Zoute Rijen', 'Barcode' => '8719587322739'],
            ['Naam' => 'Winegums', 'Barcode' => '8719587327527'],
            ['Naam' => 'Drop Munten', 'Barcode' => '8719587322345'],
            ['Naam' => 'Kruis Drop', 'Barcode' => '8719587322265'],
            ['Naam' => 'Zoute Ruitjes', 'Barcode' => '8719587323256'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['Barcode' => $product['Barcode']],
                [
                    'Naam' => $product['Naam'],
                    'IsActief' => true,
                    'Opmerking' => null,
                    'DatumAangemaakt' => now(),
                    'DatumGewijzigd' => now(),
                ],
            );
        }
    }
}
