<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving the authenticated user's profile.
     *
     * @return void
     */
    public function testGetUserProfile()
    {
        // Manually create a user without using a factory
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/user/profile');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ]);
    }

    /**
     * Test updating the authenticated user's profile.
     *
     * @return void
     */
    public function testUpdateUserProfile()
    {
        // Manually create a user without using a factory
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/user/profile/update', [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'user' => [
                    'name' => 'Updated Name',
                    'email' => 'updatedemail@example.com',
                    'role' => 'user',  // Should still be 'user' unless explicitly changed
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }
}
