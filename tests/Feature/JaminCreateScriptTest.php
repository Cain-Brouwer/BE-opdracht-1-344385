<?php

namespace Tests\Feature;

use App\Models\Magazijn;
use App\Models\Product;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The data from create_script_jamin.sql has to match the data in the assignment,
 * because the user stories refer to specific products by name.
 */
class JaminCreateScriptTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_the_script_creates_the_six_specification_tables(): void
    {
        foreach ([
            'Product',
            'Allergeen',
            'Leverancier',
            'Magazijn',
            'ProductPerAllergeen',
            'ProductPerLeverancier',
        ] as $table) {
            $this->assertTrue(
                $this->app['db']->connection()->getSchemaBuilder()->hasTable($table),
                "Tabel {$table} ontbreekt.",
            );
        }
    }

    public function test_the_script_contains_every_product_from_the_assignment(): void
    {
        $this->assertSame(13, Product::query()->count());

        $namen = ['Mintnopjes', 'Schoolkrijt', 'Honingdrop', 'Zure Beren', 'Cola Flesjes', 'Turtles',
            'Witte Muizen', 'Reuzen Slangen', 'Zoute Rijen', 'Winegums', 'Drop Munten', 'Kruis Drop',
            'Zoute Ruitjes'];

        foreach ($namen as $naam) {
            $this->assertNotNull(
                Product::query()->where('Naam', $naam)->first(),
                "Product {$naam} ontbreekt in de database.",
            );
        }
    }

    public function test_every_product_has_a_unique_barcode(): void
    {
        $barcodes = Product::query()->pluck('Barcode');

        $this->assertCount(13, $barcodes->unique());
    }

    public function test_winegums_has_no_stock_so_scenario_one_two_can_be_tested(): void
    {
        $winegums = Product::query()->where('Naam', 'Winegums')->firstOrFail();

        $this->assertFalse($winegums->heeftVoorraad(), 'Winegums zou geen voorraad moeten hebben.');
        $this->assertSame('30-10-2024', $winegums->verwachteLeveringsdatum());
    }

    public function test_cola_flesjes_has_no_allergens_so_scenario_two_two_can_be_tested(): void
    {
        $cola = Product::query()->where('Naam', 'Cola Flesjes')->firstOrFail();

        $this->assertCount(0, $cola->actieveAllergenen());
    }

    public function test_mintnopjes_has_deliveries_and_allergens(): void
    {
        $mintnopjes = Product::query()->where('Naam', 'Mintnopjes')->firstOrFail();

        $this->assertTrue($mintnopjes->heeftVoorraad());
        $this->assertSame(453, $mintnopjes->totaleVoorraad());
        $this->assertCount(2, $mintnopjes->actieveLeveringen());
        $this->assertSame(
            ['AZO-Kleurstof', 'Gelatine', 'Gluten'],
            $mintnopjes->actieveAllergenen()->pluck('Naam')->all(),
        );
    }

    public function test_every_stock_record_belongs_to_an_existing_product(): void
    {
        $this->assertSame(13, Magazijn::query()->count());
        $this->assertSame(13, Product::query()->count());
    }
}
