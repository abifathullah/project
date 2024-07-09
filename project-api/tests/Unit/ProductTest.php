<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Utilities\Enums\ProductType;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected ProductCategory $category;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = ProductCategory::factory()->create(['name' => ProductType::TOOL]);

        $this->product = Product::factory()->create([
            'name' => 'Diagonal cutting plier',
            'product_category_id' => $this->category->id,
        ]);

        $this->category->load('products');
    }

    /**
     * @return void
     */
    public function test_that_product_belongs_to_a_category(): void
    {
        $this->assertInstanceOf(ProductCategory::class, $this->product->category);
        $this->assertEquals(ProductType::TOOL, $this->product->category->name);
    }

    /**
     * @return void
     */
    public function test_that_product_category_has_products(): void
    {
        $this->assertTrue($this->category->products->contains($this->product));
        $this->assertEquals('Diagonal cutting plier', $this->product->name);
    }
}
