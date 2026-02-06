<?php

namespace Database\Factories;

use App\Models\ConsumableCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumableCategoryFactory extends Factory
{
    protected $model = ConsumableCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
