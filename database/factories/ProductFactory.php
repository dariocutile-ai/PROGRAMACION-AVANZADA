<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####?')),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->paragraph(2),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'stock' => fake()->numberBetween(0, 200),
            'reorder_level' => fake()->numberBetween(5, 60),
            'purchase_price' => fake()->randomFloat(2, 1, 250),
            'sale_price' => fake()->randomFloat(2, 1, 400),
        ];
    }
}

