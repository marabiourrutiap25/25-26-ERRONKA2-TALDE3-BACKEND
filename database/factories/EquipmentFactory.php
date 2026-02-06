<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'label' => fake()->bothify('EQ-###'),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'brand' => fake()->company(),
            'equipment_category_id' => EquipmentCategory::factory(),
        ];
    }
}
