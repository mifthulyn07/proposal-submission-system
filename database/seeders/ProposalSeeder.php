<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Seeder;
use bfinlay\SpreadsheetSeeder\SpreadsheetSeeder;
use bfinlay\SpreadsheetSeeder\SpreadsheetSeederSettings;

class ProposalSeeder extends SpreadsheetSeeder
{
    public function settings(SpreadsheetSeederSettings $set)
    {
        // By default, the seeder will process all XLSX files in /database/seeds/*.xlsx (relative to Laravel project base path)
        
        // Example setting
        $set->file = '/database/seeds/proposals.xlsx';
        $set->tablename = 'proposals';
        $set->defaults = ['created_by' => 'seed', 'updated_by' => 'seed'];
        $set->validate = [
            'topic_id'      => 'nullable|exists:topics,id',
            'student_id'    => 'nullable|exists:students,id',
            'name'          => 'required|max:100',
            'nim'           => 'nullable|max_digits:12|numeric|unique:proposals,nim',
            'type'          => 'in:thesis,appropriate_technology,journal',
            'title'         => 'required|max:255|unique:proposals,title',
            'year'          => 'required|max_digits:4|numeric|min:2016',
            'status'        => 'required|in:done,on_process',
            'adding_topic'  => 'nullable|string|unique:topics,name'
        ];
    }

    public function run(): void
    {
    }
}
