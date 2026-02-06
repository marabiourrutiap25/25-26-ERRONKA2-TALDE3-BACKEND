<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Student;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'seat' => fake()->numberBetween(1, 20),
            'date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'comments' => fake()->sentence(),
            'student_id' => Student::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
