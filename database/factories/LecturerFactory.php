<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   => User::inRandomOrder()->first()->id,
            'nip'       => fake()->unique()->numberBetween(1000000000000000,9999999999999999),
            'expertise' => fake()->randomElement(['SIG', 'SPK', 'Machine Learning', 'SIM', 'IOT']),
        ];
    }
}
