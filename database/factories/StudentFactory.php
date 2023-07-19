<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'lecturer_id'   => Lecturer::factory(),
            'nim'           => fake()->unique()->numberBetween(1000000000,9999999999),
            'class'         => "Sistem Informasi-".fake()->numberBetween(1, 6),
        ];
    }
}
