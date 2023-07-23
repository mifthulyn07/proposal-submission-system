<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Topic;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomStudent = Student::all()->random();
        return [
            'topic_id'  => Topic::all()->random()->id,
            'student_id'=> $randomStudent->id,
            'name'      => $randomStudent->user->name,
            'nim'       => $randomStudent->nim,
            'type'      => fake()->randomElement(['skripsi', 'teknologi_tepat_guna', 'jurnal']),
            'title'     => fake()->sentence(),
            'year'      => fake()->year(),
            'status'    => fake()->randomElement(['done', 'on_process']),
        ];
    }
}
