<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use Faker\Factory as Faker;

class ServiceCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            ServiceCategory::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
