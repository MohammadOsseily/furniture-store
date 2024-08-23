<?php

namespace Tests\Feature;


use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrder()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/orders/create', [
            'address_line' => '123 Test St',
            'city' => 'Test City',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Order placed successfully',
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_amount' => $product->price * 2,
        ]);
    }


}
