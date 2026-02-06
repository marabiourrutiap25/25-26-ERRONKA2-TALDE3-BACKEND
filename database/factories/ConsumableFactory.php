<?php

namespace Database\Factories;

use App\Models\Consumable;
use App\Models\ConsumableCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumableFactory extends Factory
{
    protected $model = Consumable::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'batch' => fake()->bothify('BATCH-###'),
            'brand' => fake()->company(),
            'stock' => fake()->numberBetween(1, 100),
            'min_stock' => fake()->numberBetween(1, 10),
            'expiration_date' => fake()->date(),
            'consumable_category_id' => ConsumableCategory::factory(),
        ];
    }
}
