<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Topic;
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
            'role'              => 'coordinator',
            'name'              => 'Developer',
            'gender'            => 'female',
            'phone'             => '08131234567',
            'email'             => 'developer@example.com',
            'password'          => Hash::make('developer'),
        ]);
        User::factory()->create([
            'role'              => 'lecturer',
            'name'              => 'John Doe',
            'gender'            => 'male',
            'phone'             => '08123456743',
            'email'             => 'johndoe@example.com',
            'password'          => Hash::make('johndoe123'),
        ]);
        User::factory()->create([
            'role'              => 'student',
            'name'              => 'Miftahul Ulyana Hutabarat',
            'gender'            => 'female',
            'phone'             => '08598098765',
            'email'             => 'mifthulyn07@example.com',
            'password'          => Hash::make('miftahul123'),
        ]);

        Topic::factory()->create([
            'name'              => 'Sistem Informasi Geografis',
            'date'              => '2023-07-06',
        ]);
        Topic::factory()->create([
            'name'              => 'IoT(Internet of Things)',
            'date'              => '2023-07-06',
        ]);
        Topic::factory()->create([
            'name'              => 'Machine Learning',
            'date'              => '2023-07-06',
        ]);

        // User::factory()->count(6)->create()->each(function ($user) {
        //     Proposal::factory()->create([
        //         'user_id'   => $user->id,
        //         'name'      => $user->name,
        //         'nim'       => $user->unique_numbers,
        //     ]);
        // });
    }
}
