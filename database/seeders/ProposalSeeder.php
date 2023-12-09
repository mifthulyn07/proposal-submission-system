<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proposal::factory()->create([
            'title'              => 'Rancang Bangun Sistem Informasi Pengajuan Judul',
            'adding_topic'       => null,
        ]);

        Proposal::factory()->create([
            'title'              => 'Analisis dan Rancang Sistem Pendukung Keputusan Gizi',
            'adding_topic'       => null,
        ]);

        Proposal::factory()->create([
            'title'              => 'Design User Interface Aplikasi Film Indonesia',
            'adding_topic'       => null,
        ]);
    }
}
