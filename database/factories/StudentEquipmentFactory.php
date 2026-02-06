<?php

namespace Database\Factories;

use App\Models\StudentEquipment;
use App\Models\Student;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentEquipmentFactory extends Factory
{
    protected $model = StudentEquipment::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'equipment_id' => Equipment::factory(),
            'start_datetime' => fake()->dateTime(),
            'end_datetime' => fake()->dateTime(),
        ];
    }
}
