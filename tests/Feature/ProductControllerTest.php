<?php

namespace Tests\Feature;

use App\DB\Models\Products\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase; // Rollback database transactions after each test

    public function testStoreProduct()
    {
        $response = $this->postJson('/products', [
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
            'variant' => [
                'name' => 'Test Variant',
                'stockCount' => 100,
                'additionalCount' => 50,
                'SKU' => 'ABC123',
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson('product stored successfully');

        // Assert that the product and variant are stored in the database
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
        ]);
        $this->assertDatabaseHas('product_variants', [
            'name' => 'Test Variant',
            'stockCount' => 100,
            'additionalCount' => 50,
            'SKU' => 'ABC123',
        ]);
    }

    public function testSearchProducts()
    {
        // Create some dummy products in the database
        Product::factory()->create([
            'name' => 'Product 1',
            'description' => 'Description 1',
        ]);
        Product::factory()->create([
            'name' => 'Product 2',
            'description' => 'Description 2',
        ]);
        Product::factory()->create([
            'name' => 'Another Product',
            'description' => 'Description 3',
        ]);

        // Perform a search request
        $response = $this->getJson('/products?productName=Product');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        // ... other expected fields
                    ],
                ],
                'paginator' => [
                    'currentPage',
                    'perPage',
                    'total',
                    'totalPages',
                    'currentUrl',
                    'prevUrl',
                    'prevPage',
                    'nextUrl',
                    'nextPage',
                ],
            ]);

        // Assert that the response contains the matching products
        $response->assertJsonFragment([
            'name' => 'Product 1',
            'description' => 'Description 1',
        ]);
        $response->assertJsonFragment([
            'name' => 'Product 2',
            'description' => 'Description 2',
        ]);
        $response->assertJsonMissing([
            'name' => 'Another Product',
            'description' => 'Description 3',
        ]);
    }

    public function testUpdateProduct()
    {
        // Create a product in the database
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
        ]);

        // Update the product
        $response = $this->putJson('/product/' . $product->id, [
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
            'price' => 19.99,
            'variant' => [
                'name' => 'Updated Variant',
                'stockCount' => 50,
                'additionalCount' => 25,
                'SKU' => 'XYZ789',
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson('Product updated successfully');

        // Assert that the product is updated in the database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
            'price' => 19.99,
        ]);
        $this->assertDatabaseHas('product_variants', [
            'name' => 'Updated Variant',
            'stockCount' => 50,
            'additionalCount' => 25,
            'SKU' => 'XYZ789',
        ]);
    }


    public function testDeleteProduct()
    {
        // Create a product in the database
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
        ]);

        // Delete the product
        $response = $this->deleteJson('/product/' . $product->id);

        $response->assertStatus(200)
            ->assertJson('Product deleted successfully');

        // Assert that the product is deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }


}
