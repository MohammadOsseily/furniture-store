<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListCategories()
    {
        Category::factory()->count(5)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'categories' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function testCreateCategory()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/categories/create', [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Category created successfully',
                'category' => [
                    'name' => 'Test Category',
                ],
            ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
        ]);
    }


}
