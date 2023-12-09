<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Proposal;
use Illuminate\Support\Str;
use App\Models\ProposalProcess;
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
        $coordinator = User::factory()->create([
            'name'              => 'Coordinator',
            'email'             => 'coordinator@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $coordinator->assignRole(['coordinator']);

        $kaprodi = User::factory()->create([
            'name'              => 'Kaprodi',
            'email'             => 'kaprodi@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $kaprodi->assignRole(['kaprodi', 'lecturer']);
        Lecturer::factory()->create(['user_id' => $kaprodi->id,]);

        $lecturer = User::factory()->create([
            'name'              => 'John Doe',
            'email'             => 'johndoe@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $lecturer->assignRole(['lecturer']);
        Lecturer::factory()->create(['user_id' => $lecturer->id]);

        $lecturer2 = User::factory()->create([
            'name'              => 'John Lenon',
            'email'             => 'johnlenon@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $lecturer2->assignRole(['lecturer']);
        Lecturer::factory()->create(['user_id' => $lecturer2->id]);

        $student = User::factory()->create([
            'name'              => 'Bambang',
            'email'             => 'bambang@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $student->assignRole(['student']);
        $student = Student::factory()->create(['user_id' => $student->id]);
        $student = Proposal::factory()->create([
            'student_id'        => $student->id,
            'name'              => $student->user->name,
            'nim'               => $student->nim,
            'title'             => 'Rancang Bangun Sistem Informasi Pengajuan Judul',
            'adding_topic'      => null,
        ]);

        $student2 = User::factory()->create([
            'name'              => 'Indah',
            'email'             => 'indah@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $student2->assignRole(['student']);
        $student2 = Student::factory()->create(['user_id' => $student2->id]);
        $student2 = Proposal::factory()->create([
            'student_id'        => $student2->id,
            'name'              => $student2->user->name,
            'nim'               => $student2->nim,
            'title'             => 'Analisis dan Rancang Sistem Pendukung Keputusan Gizi',
            'adding_topic'      => null,
        ]);

        $student3 = User::factory()->create([
            'name'              => 'Dinda',
            'email'             => 'Dinda@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $student3->assignRole(['student']);
        $student3 = Student::factory()->create(['user_id' => $student3->id]);
        $student3 = Proposal::factory()->create([
            'student_id'        => $student3->id,
            'name'              => $student3->user->name,
            'nim'               => $student3->nim,
            'title'             => 'Design User Interface Aplikasi Film Indonesia',
            'adding_topic'      => null,
        ]);

        $student4 = User::factory()->create([
            'name'              => 'Miftahul Ulyana Hutabarat',
            'email'             => 'miftahululyana@example.com',
            'password'          => Hash::make('12345678'),
        ]);
        $student4->assignRole(['student']);
        $student4 = Student::factory()->create(['user_id' => $student4->id]);
        $student4 = ProposalProcess::create(['student_id' => $student4->id]);
    }
}
