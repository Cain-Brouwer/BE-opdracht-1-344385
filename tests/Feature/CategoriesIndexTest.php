<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ShopProduct;
use Database\Factories\ShopProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_every_category_with_its_products(): void
    {
        $category = Category::factory()->create(['name' => 'Hardware']);
        ShopProduct::factory()->for($category)->create(['name' => 'Muis']);

        ShopProduct::factory()->create(['name' => 'Zonder categorie']);

        $response = $this->get(route('categories.index'));

        $response->assertOk();
        $response->assertSee('Hardware');
        $response->assertSee('Muis');
        $response->assertSee('Zonder categorie');
    }

    public function test_it_is_reachable_without_being_logged_in(): void
    {
        $this->get(route('categories.index'))->assertOk();
    }

    public function test_it_shows_a_message_when_there_are_no_categories(): void
    {
        $this->assertSame(0, Category::count());

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Er zijn nog geen categorieën aangemaakt.');
    }

    public function test_a_product_belongs_to_exactly_one_category(): void
    {
        $category = Category::factory()->create();
        $product = ShopProductFactory::new()->for($category)->create();

        $this->assertTrue($category->products->contains($product));
        $this->assertSame($category->id, $product->category->id);
    }
}
