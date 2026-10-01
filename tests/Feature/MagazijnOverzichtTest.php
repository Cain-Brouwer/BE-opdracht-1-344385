<?php

namespace Tests\Feature;

use App\Models\Magazijn;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MagazijnOverzichtTest extends TestCase
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

    public function test_a_guest_is_sent_to_the_login_screen(): void
    {
        $this->get(route('magazijn.index'))->assertRedirect(route('login'));
    }

    public function test_a_user_without_the_warehouse_role_is_forbidden(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)->get(route('magazijn.index'))->assertForbidden();
    }

    public function test_an_admin_may_also_open_the_overview(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->get(route('magazijn.index'))->assertOk();
    }

    public function test_it_lists_every_product_that_is_in_the_warehouse(): void
    {
        $product = Product::factory()->create(['Naam' => 'Mintnopjes']);
        Magazijn::factory()->for($product)->create(['AantalAanwezig' => 453]);

        $response = $this->actingAs($this->magazijnmedewerker)->get(route('magazijn.index'));

        $response->assertOk();
        $response->assertSee('Overzicht Magazijn Jamin');
        $response->assertSee('Mintnopjes');
        $response->assertSee($product->Barcode);
        $response->assertSee('453');
    }

    public function test_products_are_sorted_by_barcode_ascending(): void
    {
        Product::factory()->create(['Barcode' => '8719587322245']); // Turtles
        Product::factory()->create(['Barcode' => '8719587231278']); // Mintnopjes
        Product::factory()->create(['Barcode' => '8719587326713']); // Schoolkrijt

        Product::query()->get()->each(fn (Product $product) => Magazijn::factory()->for($product)->create());

        $response = $this->actingAs($this->magazijnmedewerker)->get(route('magazijn.index'));

        $response->assertOk();

        $posities = collect(['8719587231278', '8719587322245', '8719587326713'])
            ->map(fn (string $barcode) => strpos($response->getContent(), $barcode))
            ->values();

        $this->assertNotContains(false, $posities->all(), 'Niet alle barcodes komen in de response voor.');
        $this->assertSame(
            $posities->sort()->values()->all(),
            $posities->all(),
            'De producten staan niet op barcode gesorteerd.',
        );
    }

    public function test_a_product_without_stock_is_still_listed(): void
    {
        $product = Product::factory()->create(['Naam' => 'Winegums']);
        Magazijn::factory()->for($product)->zonderVoorraad()->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.index'))
            ->assertOk()
            ->assertSee('Winegums')
            ->assertSee('geen voorraad');
    }

    public function test_a_product_that_is_not_in_the_warehouse_is_not_listed(): void
    {
        Product::factory()->create(['Naam' => 'NietInMagazijn']);

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.index'))
            ->assertOk()
            ->assertDontSee('NietInMagazijn');
    }

    public function test_inactive_products_are_not_listed(): void
    {
        $product = Product::factory()->inactief()->create(['Naam' => 'UitverkochtProduct']);
        Magazijn::factory()->for($product)->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.index'))
            ->assertOk()
            ->assertDontSee('UitverkochtProduct');
    }

    public function test_each_product_links_to_its_delivery_and_allergen_screen(): void
    {
        $product = Product::factory()->create();
        Magazijn::factory()->for($product)->create();

        $this->actingAs($this->magazijnmedewerker)
            ->get(route('magazijn.index'))
            ->assertSee(route('magazijn.leveringsinformatie', $product))
            ->assertSee(route('magazijn.allergenen', $product));
    }

    public function test_the_home_page_links_to_the_overview(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('magazijn.index'))
            ->assertSee('Overzicht Magazijn Jamin');
    }
}
