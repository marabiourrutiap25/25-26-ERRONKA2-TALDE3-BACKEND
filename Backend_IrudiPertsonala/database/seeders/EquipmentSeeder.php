<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Faker\Factory as Faker;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = EquipmentCategory::all();
        if ($categories->isEmpty())
            return;

        foreach (range(1, 7) as $index) {
            Equipment::create([
                'label' => strtoupper($faker->unique()->bothify('EQ-###??')),
                'name' => $faker->word(),
                'description' => $faker->optional()->sentence() ?: null,
                'brand' => $faker->optional()->company() ?: null,
                'equipment_category_id' => $categories->random()->id,
            ]);
        }
    }
}
