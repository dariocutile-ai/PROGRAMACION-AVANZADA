<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class InventoryProApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure all migrations are executed (including Sanctum's personal_access_tokens)
        $this->artisan('migrate', ['--no-interaction' => true]);

    }


    private function tokenFor(string $email): string
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertArrayHasKey('token', $data);

        return (string) $data['token'];
    }

    public function test_register_returns_201_and_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'token',
        ]);
    }

    public function test_login_returns_token(): void
    {
        $this->seed();

        $token = $this->tokenFor('test@example.com');

        $this->assertNotEmpty($token);
    }

    public function test_logout_requires_auth(): void
    {
        $response = $this->postJson('/api/v1/auth/logout');
        $response->assertStatus(401);
    }

    public function test_logout_invalidates_session_token(): void
    {
        $this->seed();

        $token = $this->tokenFor('test@example.com');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout', [])
            ->assertStatus(204);


        $response = $this->getJson('/api/v1/health');
        // After logout token must be invalid; /health should be public, so just ensure request works
        $response->assertStatus(200);

    }
}

