<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'rol' => 'A',
            'password' => Hash::make('password'),
        ]);

        foreach (range(1, 3) as $i) {
            User::create([
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'rol' => $faker->randomElement(['A','U']),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
