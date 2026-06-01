<?php

namespace Database\Factories;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryMovement>
 */
class InventoryMovementFactory extends Factory
{
    protected $model = InventoryMovement::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['purchase', 'restock', 'sale', 'waste']);

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'type' => $type,
            'quantity' => fake()->numberBetween(1, 30),
            'unit_cost' => fake()->randomFloat(2, 0.5, 120),
            'reference_type' => null,
            'reference_id' => null,
            'note' => fake()->optional()->sentence(8),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }
}

