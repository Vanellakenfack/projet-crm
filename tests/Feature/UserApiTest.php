<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_register_a_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'User registered successfully']);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    #[Test]
    public function it_can_login_a_user()
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);
    }

    #[Test]
    public function it_can_get_user_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/user/profile');

        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id, 'name' => $user->name]);
    }

    #[Test]
    public function it_can_update_user_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->putJson('/api/user/profile', [
            'name' => 'John Updated',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Profile updated successfully']);

        $this->assertDatabaseHas('users', [
            'name' => 'John Updated',
        ]);
    }

}