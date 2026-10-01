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

class OverzichtAllergenenTest extends TestCase
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

    public function test_it_shows_the_product_name_and_barcode_above_the_table(): void
    {
        $product = Product::factory()->create(['Naam' => 'Zoute Ruitjes', 'Barcode' => '8719587323256']);
        Magazijn::factory()->for($product)->create();

        ProductPerAllergeen::factory()
            ->for($product)
            ->for(Allergeen::factory()->create(['Naam' => 'Gluten']))
            ->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.allergenen', $product))
            ->assertOk()
            ->assertSee('Overzicht Allergenen')
            ->assertSee('Zoute Ruitjes')
            ->assertSee('8719587323256')
            ->assertSee('Gluten');
    }

    public function test_allergens_are_sorted_by_name_ascending(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        foreach (['Soja', 'AZO-Kleurstof', 'Lactose'] as $naam) {
            ProductPerAllergeen::factory()
                ->for($product)
                ->for(Allergeen::factory()->create(['Naam' => $naam]))
                ->create();
        }

        $response = $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.allergenen', $product));

        $response->assertOk();

        $content = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/AZO-Kleurstof.*Lactose.*Soja/s',
            $content,
            'Allergenen staan niet op naam oplopend gesorteerd.',
        );
    }

    public function test_a_product_without_allergens_shows_the_message_and_redirects_after_four_seconds(): void
    {
        $product = Product::factory()->create(['Naam' => 'Cola Flesjes']);
        Magazijn::factory()->for($product)->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.allergenen', $product))
            ->assertOk()
            ->assertSee('In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken')
            ->assertSee('over 4 seconden teruggestuurd')
            ->assertSee('content="4;url='.route('magazijn.index').'"', false);
    }

    public function test_inactive_allergen_links_are_ignored(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        ProductPerAllergeen::factory()
            ->for($product)
            ->for(Allergeen::factory()->create(['Naam' => 'VerouderdAllergeen']))
            ->create(['IsActief' => false]);

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.allergenen', $product))
            ->assertOk()
            ->assertDontSee('VerouderdAllergeen');
    }

    public function test_a_guest_cannot_open_the_allergen_screen(): void
    {
        $product = Product::factory()->create();

        $this->get(route('magazijn.allergenen', $product))->assertRedirect(route('login'));
    }
}
