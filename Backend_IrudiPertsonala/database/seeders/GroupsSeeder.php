<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use Faker\Factory as Faker;

class GroupsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $index) {
            Group::create([
                'name' => $faker->word(),
            ]);
        }
    }
}
