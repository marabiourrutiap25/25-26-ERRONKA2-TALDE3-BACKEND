<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consumable;
use App\Models\ConsumableCategorie;
use Faker\Factory as Faker;

class ConsumablesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categories = ConsumableCategorie::all();
        if ($categories->isEmpty())
            return;

        foreach (range(1, 7) as $index) {
            $expiration = $faker->optional()->dateTimeBetween('+1 month', '+2 years');

            Consumable::create([
                'name' => $faker->word(),
                'description' => $faker->optional()->sentence() ?: null,
                'batch' => $faker->optional()->bothify('BATCH-###??') ?: null,
                'brand' => $faker->optional()->company() ?: null,
                'stock' => $faker->numberBetween(5, 100),
                'min_stock' => $faker->optional()->numberBetween(1, 10) ?: null,
                'expiration_date' => $expiration ? $expiration->format('Y-m-d') : null,
                'consumables_categorie_id' => $categories->random()->id,
            ]);
        }
    }
}
