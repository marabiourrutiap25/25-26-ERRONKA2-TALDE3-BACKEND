<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'day' => fake()->numberBetween(1, 7),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'group_id' => Group::factory(),
        ];
    }
}
