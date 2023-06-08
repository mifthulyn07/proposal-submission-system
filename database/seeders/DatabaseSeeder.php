<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Proposal::factory(5)->create();

        User::factory()->create([
            'role'              => 'admin',
            'name'              => 'Developer',
            'unique_numbers'    => '0702192031',
            'gender'            => 'female',
            'phone'             => '08131234567',
            'semester'          => 8,
            'email'             => 'developer@example.com',
            'password'          => Hash::make('developer'),
        ]);

        User::factory()->count(5)->create()->each(function ($user) {
            Proposal::factory()->create([
                'user_id'   => $user->id,
                'name'      => $user->name,
                'nim'       => $user->unique_numbers,
            ]);
        });
    }
}
