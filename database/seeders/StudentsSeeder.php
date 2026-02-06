<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Group;
use Faker\Factory as Faker;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $groups = Group::all();
        if ($groups->isEmpty())
            return;

        foreach (range(1, 7) as $index) {
            Student::create([
                'name' => $faker->firstName(),
                'surnames' => $faker->lastName() . ' ' . $faker->lastName(),
                'group_id' => $groups->random()->id,
            ]);
        }
    }
}
