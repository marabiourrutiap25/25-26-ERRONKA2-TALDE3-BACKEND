<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentCategory;
use Faker\Factory as Faker;

class EquipmentCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            EquipmentCategory::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
