<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentableType = fake()->randomElement([
            Product::class,
            Category::class,
            Supplier::class,
        ]);

        $commentableId = match ($commentableType) {
            Product::class => Product::factory(),
            Category::class => Category::factory(),
            default => Supplier::factory(),
        };

        // Si usamos factory anidada, el ID se resolverá en BD al insertar.
        // Para coherencia, sobrescribimos en el seeder cuando tengamos IDs.
        return [
            'user_id' => User::factory(),
            'commentable_id' => $commentableId instanceof \Illuminate\Database\Eloquent\Factories\Factory ? 1 : $commentableId,
            'commentable_type' => $commentableType,
            'content' => fake()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

