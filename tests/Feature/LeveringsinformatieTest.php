<?php

namespace Tests\Feature;

use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeveringsinformatieTest extends TestCase
{
    use RefreshDatabase;

    private User $magazijnmedewerker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->magazijnmedewerker = User::factory()->create();
        $this->magazijnmedewerker->assignRole('magazijnmedewerker');
    }

    public function test_it_shows_the_supplier_details_above_the_table(): void
    {
        $leverancier = Leverancier::factory()->create([
            'Naam' => 'Venco',
            'ContactPersoon' => 'Bert van Linge',
            'LeverancierNummer' => 'L1029384719',
            'Mobiel' => '06-28493827',
        ]);

        $product = Product::factory()->create(['Naam' => 'Mintnopjes']);
        Magazijn::factory()->for($product)->create(['AantalAanwezig' => 453]);
        ProductPerLeverancier::factory()->for($product)->for($leverancier)->create([
            'DatumLevering' => '2024-10-09',
            'Aantal' => 23,
            'DatumEerstVolgendeLevering' => '2024-10-16',
        ]);

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product))
            ->assertOk()
            ->assertSee('Levering Informatie')
            ->assertSee('Venco')
            ->assertSee('Bert van Linge')
            ->assertSee('L1029384719')
            ->assertSee('06-28493827');
    }

    public function test_it_lists_every_delivery_with_amount_and_next_expected_date(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create(['AantalAanwezig' => 453]);

        ProductPerLeverancier::factory()->for($product)->create([
            'DatumLevering' => '2024-10-18',
            'Aantal' => 21,
            'DatumEerstVolgendeLevering' => '2024-10-25',
        ]);
        ProductPerLeverancier::factory()->for($product)->create([
            'DatumLevering' => '2024-10-09',
            'Aantal' => 23,
            'DatumEerstVolgendeLevering' => '2024-10-16',
        ]);

        $response = $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product));

        $response->assertOk()->assertSee('09-10-2024')->assertSee('18-10-2024');

        $first = strpos($response->getContent(), '09-10-2024');
        $second = strpos($response->getContent(), '18-10-2024');

        $this->assertLessThan($second, $first, 'Leveringen staan niet op datum oplopend gesorteerd.');
    }

    public function test_a_product_without_stock_shows_the_message_and_redirects_after_four_seconds(): void
    {
        $product = Product::factory()->create(['Naam' => 'Winegums']);
        Magazijn::factory()->for($product)->zonderVoorraad()->create();
        ProductPerLeverancier::factory()->for($product)->create([
            'DatumLevering' => '2024-10-16',
            'DatumEerstVolgendeLevering' => '2024-10-30',
        ]);

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product))
            ->assertOk()
            ->assertSee('Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende')
            ->assertSee('30-10-2024')
            ->assertSee('over 4 seconden teruggestuurd')
            ->assertSee('http-equiv="refresh"', false)
            ->assertSee('content="4;url='.route('magazijn.index').'"', false);
    }

    public function test_a_product_without_stock_without_expected_date_says_so(): void
    {
        $product = Product::factory()->create(['Naam' => 'Zoute Ruitjes']);
        Magazijn::factory()->for($product)->create(['AantalAanwezig' => 0]);
        ProductPerLeverancier::factory()->for($product)->zonderVolgendeLevering()->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product))
            ->assertOk()
            ->assertSee('niet bekend');
    }

    public function test_inactive_products_are_not_reachable(): void
    {
        $product = Product::factory()->inactief()->create();
        Magazijn::factory()->for($product)->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product))
            ->assertNotFound();
    }
}
