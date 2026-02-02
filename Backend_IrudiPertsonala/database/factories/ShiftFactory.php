<?php

namespace Database\Factories;

use App\Models\Shift;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition(): array
    {
        return [
            'type' => fake()->word(),
            'data' => fake()->date(),
            'student_id' => Student::factory(),
        ];
    }
}
