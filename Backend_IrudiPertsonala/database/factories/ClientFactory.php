<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surnames' => fake()->lastName(),
            'telephone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'home_client' => fake()->boolean(),
        ];
    }
}
