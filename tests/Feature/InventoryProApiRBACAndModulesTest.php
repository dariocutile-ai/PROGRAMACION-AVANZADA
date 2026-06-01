<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Role;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryProApiRBACAndModulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--no-interaction' => true]);
        $this->seed();
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

    private function makeHeaders(string $token): array
    {
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_reports_requires_auth_and_role(): void
    {
        $this->getJson('/api/v1/reports/low-stock')->assertStatus(401);

        $employeeToken = $this->tokenFor('employee@example.com');
        $this->getJson('/api/v1/reports/low-stock', $this->makeHeaders($employeeToken))
            ->assertStatus(200);

        $unAuthed = $this->getJson('/api/v1/reports/most-sold');
        $unAuthed->assertStatus(401);
    }

    public function test_inventory_movements_requires_auth_and_role(): void
    {
        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => 1,
            'type' => 'purchase',
            'quantity' => 1,
            'unit_cost' => 10.50,
            'note' => 'test',
        ])->assertStatus(401);

        $employeeToken = $this->tokenFor('employee@example.com');
        $product = Product::query()->inRandomOrder()->first();

        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 2,
            'unit_cost' => 12.00,
        ], $this->makeHeaders($employeeToken))
            ->assertStatus(403);

        $managerToken = $this->tokenFor('manager@example.com');

        $before = Product::query()->findOrFail($product->id)->stock;

        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 2,
            'unit_cost' => 12.00,
            'note' => 'manager purchase',
        ], $this->makeHeaders($managerToken))
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'product_id', 'type', 'direction', 'quantity', 'unit_cost', 'created_at',
                ],
            ]);

        $after = Product::query()->findOrFail($product->id)->stock;
        $this->assertSame($before + 2, $after);

        $this->assertDatabaseHas('inventory_movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 2,
        ]);
    }

    public function test_inventory_movements_validation_422(): void
    {

        $managerToken = $this->tokenFor('manager@example.com');
        $product = Product::query()->inRandomOrder()->first();

        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            // missing quantity
            'unit_cost' => 12.00,
        ], $this->makeHeaders($managerToken))->assertStatus(422);

        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 0,
            'unit_cost' => 12.00,
        ], $this->makeHeaders($managerToken))->assertStatus(422);

        $this->postJson('/api/v1/inventory/movements', [
            'product_id' => $product->id,
            'type' => 'purchase',
            'quantity' => 1,
            'unit_cost' => -1,
        ], $this->makeHeaders($managerToken))->assertStatus(422);
    }

    public function test_reports_return_arrays(): void
    {
        $employeeToken = $this->tokenFor('employee@example.com');

        $this->getJson('/api/v1/reports/low-stock', $this->makeHeaders($employeeToken))
            ->assertStatus(200)
            ->assertJsonStructure(['data']);

        $this->getJson('/api/v1/reports/most-sold', $this->makeHeaders($employeeToken))
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_comments_can_be_created_and_listed_polymorphically(): void
    {
        $managerToken = $this->tokenFor('manager@example.com');

        $product = Product::query()->inRandomOrder()->first();

        $this->postJson('/api/v1/' . 'products' . '/' . $product->id . '/comments', [
            'content' => 'Great product',
        ], $this->makeHeaders($managerToken))
            ->assertStatus(201)
            ->assertJsonStructure([
                'id', 'content', 'user', 'commentable', 'created_at',
            ]);

        $this->getJson('/api/v1/products/' . $product->id . '/comments', $this->makeHeaders($managerToken))
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}

