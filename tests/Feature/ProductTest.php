<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created(): void
    {
        $product = Product::create([
            'name' => 'Apple iPhone 15 Pro',
            'slug' => 'apple-iphone-15-pro',
            'description' => 'Premium smartphone.',
            'price' => 125000,
            'discount_price' => 119999,
            'category' => 'Smartphones',
            'brand' => 'Apple',
            'stock' => 15,
            'is_active' => true,
            'specifications' => [
                'display' => '6.1-inch OLED',
                'storage' => '256GB',
            ],
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'slug' => 'apple-iphone-15-pro',
        ]);
    }

    public function test_product_specifications_are_cast_to_array(): void
    {
        $product = Product::create([
            'name' => 'Test Smartphone',
            'slug' => 'test-smartphone',
            'description' => 'Test description.',
            'price' => 50000,
            'discount_price' => 45000,
            'category' => 'Smartphones',
            'brand' => 'Test Brand',
            'stock' => 10,
            'is_active' => true,
            'specifications' => [
                'display' => 'AMOLED',
                'storage' => '128GB',
            ],
        ]);

        $savedProduct = Product::findOrFail($product->id);

        $this->assertIsArray($savedProduct->specifications);

        $this->assertEquals(
            'AMOLED',
            $savedProduct->specifications['display']
        );
    }
}
