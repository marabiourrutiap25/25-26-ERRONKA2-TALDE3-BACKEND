<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Faker\Factory as Faker;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            $email = $faker->unique()->safeEmail() ?? null;

            Client::create([
                'name' => $faker->firstName(),
                'surnames' => $faker->lastName() . ' ' . $faker->lastName(),
                'telephone' => $faker->optional()->phoneNumber() ?: null,
                'email' => $email,
                'home_client' => $faker->boolean(),
            ]);
        }
    }
}
