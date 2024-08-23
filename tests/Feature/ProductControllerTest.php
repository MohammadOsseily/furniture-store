<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListProducts()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'products' => [
                    '*' => ['id', 'name', 'price', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function testCreateProduct()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/products/create', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100.00,
            'category_id' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => [
                    'name' => 'Test Product',
                    'price' => 100.00,
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 100.00,
        ]);
    }


}
