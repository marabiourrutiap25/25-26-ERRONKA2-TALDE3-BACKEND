<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surnames' => fake()->lastName(),
            'group_id' => Group::factory(),
        ];
    }
}
