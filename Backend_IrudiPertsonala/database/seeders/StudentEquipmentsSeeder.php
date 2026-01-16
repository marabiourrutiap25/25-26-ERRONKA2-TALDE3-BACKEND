<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Equipment;
use Faker\Factory as Faker;

class StudentEquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $students = Student::all();
        $equipments = Equipment::all();

        if ($students->isEmpty() || $equipments->isEmpty()) {
            $this->command->info('No students or equipments found, seeding aborted.');
            return;
        }

        foreach (range(1, 7) as $index) {
            $start = $faker->dateTimeBetween('-1 month', '+1 month');
            $end = (clone $start)->modify('+2 hours');

            DB::table('student_equipments')->insert([
                'student_id' => $students->random()->id,
                'equipment_id' => $equipments->random()->id,
                'start_datetime' => $start,
                'end_datetime' => $end,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
