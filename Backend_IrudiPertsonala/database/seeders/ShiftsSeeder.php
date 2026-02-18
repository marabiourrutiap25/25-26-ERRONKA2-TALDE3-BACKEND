<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\Student;
use Faker\Factory as Faker;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $students = Student::all();

        if ($students->isEmpty()) {
            $this->command->info('No students found, seeding aborted.');
            return;
        }

        foreach (range(1, 7) as $index) {
            Shift::create([
                'type' => $faker->randomElement(['M', 'G']),
                'data' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'student_id' => $students->random()->id,
            ]);
        }
    }
}
