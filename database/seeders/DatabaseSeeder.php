<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
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
        $user1 = User::factory()->create([
            'name'              => 'Developer',
            'gender'            => 'female',
            'phone'             => '08131234567',
            'email'             => 'developer@example.com',
            'password'          => Hash::make('developer'),
        ]);
        $user1->roles()->attach(Role::create(['name' => 'coordinator']));
        $user1->roles()->attach(Role::create(['name' => 'lecturer']));
        $user1->lecturer()->create([
            'nip' => '100023022110123',
        ]);

        $user2 = User::factory()->create([
            'name'              => 'John Doe',
            'gender'            => 'male',
            'phone'             => '08123456743',
            'email'             => 'johndoe@example.com',
            'password'          => Hash::make('johndoe123'),
        ]);
        $user2->roles()->attach(Role::where('name', 'lecturer')->first());
        $user2->lecturer()->create([
            'nip' => '100023022110122',
        ]);

        $user3 = User::factory()->create([
            'name'              => 'Miftahul Ulyana Hutabarat',
            'gender'            => 'female',
            'phone'             => '08598098765',
            'email'             => 'mifthulyn07@example.com',
            'password'          => Hash::make('miftahul123'),
        ]);
        $user3->roles()->attach(Role::create(['name' => 'student']));
        $user3->student()->create([
            'nim'           => '0702192031',
            'class'         => 'Sistem Informasi-3',
            'lecturer_id'   => '2',
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
    }
}
