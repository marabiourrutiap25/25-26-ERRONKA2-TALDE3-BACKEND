<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsumableCategorie;
use Faker\Factory as Faker;

class ConsumablesCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            ConsumableCategorie::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
