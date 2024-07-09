<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @return void
     */
    public function test_can_create_a_product(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Scanner']);

        $response = $this->postJson('/api/products', [
            'name' => 'ScanTool',
            'product_category_id' => $category->id,
            'price' => 1500,
            'description' => 'ScanTool use to scan system for error and show diagnostic.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'ScanTool',
                    'product_category_id' => $category->id,
                ],
            ]);

        $this->assertDatabaseHas('products', ['name' => 'ScanTool']);
    }

    /**
     * @return void
     */
    public function test_can_update_a_product(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Scanner']);
        $product = Product::factory()->create([
            'name' => 'ScanTool',
            'product_category_id' => $category->id,
            'price' => 550,
        ]);

        $newCategory = ProductCategory::factory()->create(['name' => 'Scanner v2']);

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'ScanTool Pro',
            'product_category_id' => $newCategory->id,
            'price' => 750,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'ScanTool Pro',
                    'product_category_id' => $newCategory->id,
                    'price' => 750,
                ],
            ]);

        $this->assertDatabaseHas('products', ['name' => 'ScanTool Pro']);
    }

    /**
     * @return void
     */
    public function test_can_delete_a_product(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Scanner']);
        $product = Product::factory()->create([
            'name' => 'ScanTool',
            'product_category_id' => $category->id,
        ]);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    /**
     * @return void
     */
    public function test_can_show_a_product(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Scanner']);
        $product = Product::factory()->create([
            'name' => 'ScanTool',
            'product_category_id' => $category->id,
        ]);

        $response = $this->getJson("/api/products/{$product->id}/?with=category");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'ScanTool',
                    'product_category_id' => $category->id,
                    'category' => [
                        'name' => 'Scanner',
                    ],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function test_can_list_products_with_category(): void
    {
        $category = ProductCategory::factory()->create(['name' => 'Scanner']);
        $products = Product::factory()->count(3)->create([
            'product_category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/products?with=category');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'original' => [
                        '*' => ['id', 'name', 'product_category_id'],
                    ],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function test_returns_error_on_product_creation_requires_valid_data(): void
    {
        $response = $this->post('/api/products', [
            'name' => '',
            'price' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['name', 'price']);
    }
}
