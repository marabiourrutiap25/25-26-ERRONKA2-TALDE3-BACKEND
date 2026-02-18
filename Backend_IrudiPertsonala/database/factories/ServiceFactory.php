<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 10, 100),
            'home_price' => fake()->randomFloat(2, 5, 80),
            'duration' => fake()->numberBetween(10, 120),
            'service_category_id' => ServiceCategory::factory(),
        ];
    }
}
