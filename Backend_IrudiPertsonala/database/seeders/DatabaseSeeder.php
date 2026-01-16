<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Categorías primero
        $this->call([
            ConsumablesCategorySeeder::class,
            EquipmentCategorySeeder::class,
            ServiceCategorySeeder::class,
            GroupsSeeder::class,
        ]);

        // Entidades principales
        $this->call([
            EquipmentSeeder::class,
            ServicesSeeder::class,
            ClientsSeeder::class,
            StudentsSeeder::class,
        ]);

        // Entidades dependientes
        $this->call([
            AppointmentsSeeder::class,
            ShiftsSeeder::class,
            SchedulesSeeder::class,
            ConsumablesSeeder::class,
        ]);

        // Tablas pivot / n:m
        $this->call([
            AppointmentServicesSeeder::class,
            StudentConsumablesSeeder::class,
            StudentEquipmentsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
