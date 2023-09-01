<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
