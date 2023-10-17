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
        $user1 = User::create([
            'name'              => 'Developer',
            'gender'            => 'female',
            'phone'             => '08131234567',
            'email'             => 'developer@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $user1->assignRole('coordinator');

        $user2 = User::create([
            'name'              => 'John Doe',
            'gender'            => 'male',
            'phone'             => '08123456743',
            'email'             => 'johndoe@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $user2->assignRole('lecturer');
        $user2->lecturer()->create([
            'nip' => '100023022110122',
        ]);

        $user3 = User::create([
            'name'              => 'Miftahul Ulyana Hutabarat',
            'gender'            => 'female',
            'phone'             => '08598098765',
            'email'             => 'miftahululyana@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $user3->assignRole('student');
        $user3student = $user3->student()->create([
            'nim'           => '0702192031',
            'class'         => 'SI-3',
            'lecturer_id'   => '1',
        ]);
        $user3student->proposal_process()->create([
            'student_id'    => $user3student->id,
        ]);
    }
}
