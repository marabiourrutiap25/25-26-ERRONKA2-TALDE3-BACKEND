<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Consumable;
use Faker\Factory as Faker;

class StudentConsumablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $students = Student::all();
        $consumables = Consumable::all();

        if ($students->isEmpty() || $consumables->isEmpty()) {
            $this->command->info('No students or consumables found, seeding aborted.');
            return;
        }

        foreach (range(1, 7) as $index) {
            DB::table('student_consumables')->insert([
                'student_id' => $students->random()->id,
                'consumable_id' => $consumables->random()->id,
                'date' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'quantity' => $faker->optional()->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
