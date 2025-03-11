<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TranslationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
         $token = $user->createToken('API Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/translations', [
            'locale' => 'en',
            'key' => 'welcome',
            'value' => 'Welcome!',
            'tags' => ['general']
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function authenticated_user_can_export_translations()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->getJson('/api/v1/translations/export', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['translations']);
    }


    /** @test */
    public function unauthorized_user_cannot_export_translations()
    {
        $response = $this->getJson('/api/v1/translations/export');

        $response->assertStatus(401);
    }
}


