<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PerformanceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function api_response_time_is_below_500ms()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $start = microtime(true);
        $response = $this->getJson('/api/translations/export', [
            'Authorization' => "Bearer $token"
        ]);
        $end = microtime(true);
        
        $responseTime = ($end - $start) * 1000; // Convert to milliseconds

        $this->assertLessThan(500, $responseTime, "Response time exceeded 500ms");
    }
}
