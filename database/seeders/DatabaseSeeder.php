<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TopicSeeder;
use Database\Seeders\RolePermissionSeeder;
use bfinlay\SpreadsheetSeeder\SpreadsheetSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SpreadsheetSeeder::class,
            ProposalSeeder::class,
            RolePermissionSeeder::class,
            TopicSeeder::class,
            UserSeeder::class,
        ]);
    }
}
