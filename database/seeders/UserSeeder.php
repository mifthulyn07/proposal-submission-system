<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coordinator = User::create([
            'name'              => 'Developer',
            'gender'            => 'female',
            'phone'             => '08131234567',
            'email'             => 'developer@example.com',
            'password'          => Hash::make('developer'),
        ]);
        $coordinator->assignRole('coordinator');

        $lecturer = User::create([
            'name'              => 'John Doe',
            'gender'            => 'male',
            'phone'             => '08123456743',
            'email'             => 'johndoe@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $lecturer->assignRole('lecturer');
        $lecturer->lecturer()->create([
            'nip' => '100023022110122',
        ]);

        $student = User::create([
            'name'              => 'Miftahul Ulyana Hutabarat',
            'gender'            => 'female',
            'phone'             => '08598098765',
            'email'             => 'miftahululyana@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $student->assignRole('student');
        $student->student()->create([
            'nim'           => '0702192031',
            'class'         => 'SI-3',
            // 'lecturer_id'   => '2',
        ]);
    }
}
