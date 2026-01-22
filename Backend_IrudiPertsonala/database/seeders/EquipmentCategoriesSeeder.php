<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentCategorie;
use Faker\Factory as Faker;

class EquipmentCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            EquipmentCategorie::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
