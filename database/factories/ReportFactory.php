<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $type = fake()->randomElement([
            'low_stock',
            'most_sold',
            'recent_movements',
            'inventory_summary',
            'category_stock',
        ]);

        return [
            'type' => $type,
            'title' => ucfirst(str_replace('_', ' ', $type)),
            'user_id' => User::factory(),
            'payload' => [
                'generated_at' => now()->toDateTimeString(),
            ],
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }
}

