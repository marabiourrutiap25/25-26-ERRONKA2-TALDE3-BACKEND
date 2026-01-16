<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategorie;
use Faker\Factory as Faker;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = ServiceCategorie::all();
        if ($categories->isEmpty())
            return;

        foreach (range(1, 7) as $index) {
            Service::create([
                'name' => $faker->word(),
                'price' => $faker->randomFloat(2, 50, 500),
                'home_price' => $faker->randomFloat(2, 50, 500),
                'duration' => $faker->optional()->numberBetween(30, 180) ?: null,
                'service_categories_id' => $categories->random()->id,
            ]);
        }
    }
}
