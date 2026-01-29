<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsumableCategory;
use Faker\Factory as Faker;

class ConsumableCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            ConsumableCategory::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
