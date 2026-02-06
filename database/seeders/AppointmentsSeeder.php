<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Student;
use App\Models\Client;
use Faker\Factory as Faker;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $students = Student::all();
        $clients = Client::all();

        if ($students->isEmpty() || $clients->isEmpty()) {
            $this->command->info('No students or clients found, seeding aborted.');
            return;
        }

        foreach (range(1, 7) as $index) {
            $date = $faker->dateTimeBetween('-1 month', '+1 month');
            $start = $faker->time('H:i:s');
            $end = date('H:i:s', strtotime($start) + 3600); // +1 hora

            Appointment::create([
                'seat' => $faker->numberBetween(1, 20),
                'date' => $date->format('Y-m-d'),
                'start_time' => $start,
                'end_time' => $end,
                'comments' => $faker->optional()->sentence(),
                'student_id' => $students->random()->id,
                'client_id' => $clients->random()->id,
            ]);
        }
    }
}
