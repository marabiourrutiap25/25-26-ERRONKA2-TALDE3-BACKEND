<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Service;
use Faker\Factory as Faker;

class AppointmentServicesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $appointments = Appointment::all();
        $services = Service::all();
        if ($appointments->isEmpty() || $services->isEmpty())
            return;

        foreach (range(1, 7) as $i) {
            DB::table('appointment_services')->insert([
                'appointment_id' => $appointments->random()->id,
                'service_id' => $services->random()->id,
                'comments' => $faker->optional()->sentence() ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
