<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedules;
use App\Models\Group;
use Faker\Factory as Faker;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $groups = Group::all();

        if ($groups->isEmpty()) {
            $this->command->info('No groups found, seeding aborted.');
            return;
        }

        foreach (range(1, 7) as $index) {
            $startDate = $faker->dateTimeBetween('-1 month', '+1 month');
            $endDate = $faker->dateTimeBetween($startDate, '+3 months');
            $startTime = $faker->time('H:i:s');
            $endTime = date('H:i:s', strtotime($startTime) + 3600); // +1 hora

            Schedules::create([
                'day' => $faker->numberBetween(1, 7),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'group_id' => $groups->random()->id,
            ]);
        }
    }
}
