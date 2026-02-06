<?php

namespace Database\Factories;

use App\Models\StudentConsumable;
use App\Models\Student;
use App\Models\Consumable;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentConsumableFactory extends Factory
{
    protected $model = StudentConsumable::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'consumable_id' => Consumable::factory(),
            'date' => fake()->date(),
            'quantity' => fake()->numberBetween(1, 10),
        ];
    }
}
