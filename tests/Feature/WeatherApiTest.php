<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                'token'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }

    public function test_login_user()
    {
        $user = User::factory()->create([
            'email' => 'loginuser@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'loginuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function test_get_weather_requires_auth()
    {
        $response = $this->getJson('/api/weather?city=Quito');

        $response->assertStatus(401);
    }

    public function test_get_weather_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum'); 

        $response = $this->getJson('/api/weather?city=Quito');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'city',
                'country',
                'local_time',
                'temperature',
                'condition',
                'wind_kph',
                'humidity',
            ]);
    }
}
