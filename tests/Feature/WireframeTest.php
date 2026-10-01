<?php

namespace Tests\Feature;

use App\Models\Allergeen;
use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerAllergeen;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The screens have to match the wireframes from the assignment, including the
 * order of the columns.
 */
class WireframeTest extends TestCase
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

    public function test_the_overview_columns_are_in_the_wireframe_order(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        $response = $this->actingAs($this->magazijnmedewerker)->get(route('magazijn.index'));

        $response->assertOk();

        $this->assertColumnOrder($response->getContent(), [
            'Barcode',
            'Naam',
            'Verpakkingseenheid',
            'Aantal aanwezig',
            'Allergenen Info',
            'Leverantie Info',
        ]);
    }

    public function test_the_allergen_icon_comes_before_the_delivery_icon(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        $content = $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.index'))
            ->getContent();

        $allergenen = strpos($content, route('magazijn.allergenen', $product));
        $leverantie = strpos($content, route('magazijn.leveringsinformatie', $product));

        $this->assertLessThan($leverantie, $allergenen, 'Allergenen Info moet links van Leverantie Info staan.');
    }

    public function test_the_delivery_screen_columns_are_in_the_wireframe_order(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        $content = $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.leveringsinformatie', $product))
            ->getContent();

        $this->assertColumnOrder($content, [
            'Naam Product',
            'Datum laatste levering',
            'Aantal',
            'Eerstvolgende levering',
        ]);
    }

    public function test_the_allergen_screen_columns_are_in_the_wireframe_order(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();
        ProductPerAllergeen::factory()
            ->for($product)
            ->for(Allergeen::factory()->create(['Naam' => 'Gluten']))
            ->create();

        $content = $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.allergenen', $product))
            ->getContent();

        $this->assertColumnOrder($content, ['Naam', 'Omschrijving']);
    }

    /**
     * Assert that the given headers appear in the response in the given order.
     *
     * @param  list<string>  $koppen
     */
    private function assertColumnOrder(string $html, array $koppen): void
    {
        $positie = 0;

        foreach ($koppen as $kop) {
            $gevonden = strpos($html, '>'.$kop.'<', $positie);

            $this->assertNotFalse(
                $gevonden,
                "Kolomkop {$kop} ontbreekt in de response.",
            );
            $this->assertGreaterThanOrEqual(
                $positie,
                $gevonden,
                "Kolom {$kop} staat niet in de volgorde van de wireframe.",
            );

            $positie = $gevonden;
        }
    }
}
