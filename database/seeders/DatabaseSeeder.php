<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TopicSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            TopicSeeder::class,
        ]);

        // User::factory()->create([
        //     'name'              => 'Developer',
        //     'gender'            => 'female',
        //     'phone'             => '08131234567',
        //     'email'             => 'developer@example.com',
        //     'password'          => Hash::make('developer'),
        // ]);

        // $user1 = User::factory()->create([
        //     'name'              => 'Developer',
        //     'gender'            => 'female',
        //     'phone'             => '08131234567',
        //     'email'             => 'developer@example.com',
        //     'password'          => Hash::make('developer'),
        // ]);
        // $user1->roles()->attach(Role::create(['name' => 'coordinator']));
        // $user1->roles()->attach(Role::create(['name' => 'lecturer']));
        // $user1->lecturer()->create([
        //     'nip' => '100023022110123',
        // ]);

        // $user2 = User::factory()->create([
        //     'name'              => 'John Doe',
        //     'gender'            => 'male',
        //     'phone'             => '08123456743',
        //     'email'             => 'johndoe@example.com',
        //     'password'          => Hash::make('johndoe123'),
        // ]);
        // $user2->roles()->attach(Role::where('name', 'lecturer')->first());
        // $user2->lecturer()->create([
        //     'nip' => '100023022110122',
        // ]);

        // $user3 = User::factory()->create([
        //     'name'              => 'Miftahul Ulyana Hutabarat',
        //     'gender'            => 'female',
        //     'phone'             => '08598098765',
        //     'email'             => 'miftahululyana07@example.com',
        //     'password'          => Hash::make('miftahul123'),
        // ]);
        // $user3->roles()->attach(Role::create(['name' => 'student']));
        // $user3->student()->create([
        //     'nim'           => '0702192031',
        //     'class'         => 'Sistem Informasi-3',
        //     'lecturer_id'   => '2',
        // ]); 

        // User::factory()->count(10)->create()->each(function ($user) {
        //     $roles = Role::all()->random()->id;
        //     $user->roles()->attach($roles);

        //     if($user->hasRole('student')){
        //         $student = new Student();
        //         $student->user_id = $user->id;
        //         $student->nim  = fake()->unique()->numberBetween(1000000000,9999999999);
        //         $student->class = "Sistem Informasi-".fake()->numberBetween(1, 6);
        //         $student->save();
        //     }
        //     if($user->hasRole('lecturer')){
        //         $lecturer = new Lecturer();
        //         $lecturer->user_id = $user->id;
        //         $lecturer->nip  = fake()->unique()->numberBetween(1000000000,9999999999);
        //         $lecturer->save();
        //     }
        // });

        // Topic::factory()->create([
        //     'name'              => 'Sistem Informasi Geografis',
        //     'date'              => '2023-07-06',
        // ]);
        // Topic::factory()->create([
        //     'name'              => 'IoT(Internet of Things)',
        //     'date'              => '2023-07-06',
        // ]);
        // Topic::factory()->create([
        //     'name'              => 'Machine Learning',
        //     'date'              => '2023-07-06',
        // ]);

        // Proposal::factory()->count(3)->create();
    }
}
