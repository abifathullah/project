<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected string $newProductCategory;
    protected string $newProduct;

    protected ProductCategory $category;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->newProductCategory = 'Test tool';

        $this->newProduct = 'Test pen';

        $this->category = ProductCategory::factory()->create([
            'name' => $this->newProductCategory,
        ]);

        $this->product = Product::factory()->create([
            'name' => $this->newProduct,
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
        $this->assertEquals($this->newProductCategory, $this->product->category->name);
    }

    /**
     * @return void
     */
    public function test_that_product_category_has_products(): void
    {
        $this->assertTrue($this->category->products->contains($this->product));
        $this->assertEquals($this->newProduct, $this->product->name);
    }
}
