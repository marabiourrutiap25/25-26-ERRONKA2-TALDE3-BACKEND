<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\EquipmentCategorie;
use Faker\Factory as Faker;

class EquipmentsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = EquipmentCategorie::all();
        if ($categories->isEmpty())
            return;

        foreach (range(1, 7) as $index) {
            Equipment::create([
                'label' => strtoupper($faker->unique()->bothify('EQ-###??')),
                'name' => $faker->word(),
                'description' => $faker->optional()->sentence() ?: null,
                'brand' => $faker->optional()->company() ?: null,
                'equipment_categories_id' => $categories->random()->id,
            ]);
        }
    }
}
