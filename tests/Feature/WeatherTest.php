<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;

class WeatherTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setelah tiap test

    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /** @test */
    #[Test]
    public function it_can_get_weather_data()
    {
        // Mocking API response
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'main' => ['temp' => 25, 'humidity' => 60],
                'weather' => [['description' => 'clear sky']],
                'name' => 'Jakarta',
            ], 200),
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->getJson('/api/weather', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                    'name' => 'Jakarta',
                    'main' => [
                        'temp' => 25,
                        'humidity' => 60,
                    ],
                     'weather' => [
                        ['description' => 'clear sky'],
                    ],
                 ]);
    }
}
