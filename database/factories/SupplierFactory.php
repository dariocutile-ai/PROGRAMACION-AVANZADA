<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            // suppliers.name es UNIQUE (según constraints del modelo/migración)
            'name' => fake()->unique()->company(),
            'email' => fake()->unique()->safeEmail(),

            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }
}

