<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsumablesCategorie;
use Faker\Factory as Faker;

class ConsumablesCategorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            ConsumablesCategorie::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
