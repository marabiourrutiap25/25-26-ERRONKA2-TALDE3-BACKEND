<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategorie;
use Faker\Factory as Faker;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            ServiceCategorie::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
