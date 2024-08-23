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

    public function testUpdateOrderStatus()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = JWTAuth::fromUser($user);
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/orders/{$order->id}/update", [
            'status' => 'shipped',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Order status updated successfully',
                'order' => [
                    'status' => 'shipped',
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'shipped',
        ]);
    }


}
