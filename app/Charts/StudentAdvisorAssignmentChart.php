<?php

namespace App\Charts;

use App\Models\Lecturer;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StudentAdvisorAssignmentChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $lecturers = Lecturer::with('user')->with('proposals')->get();
        // dd($lecturers);

        $data = $lecturers->map(function ($lecturer) {
            return $lecturer->proposals->count();
        })->toArray();
        
        $labels = $lecturers->map(function ($lecturer) {
            return $lecturer->user->name;
        })->toArray();

        return $this->chart->barChart()
            ->setTitle('Student advisor assignment chart.')
            ->setSubtitle('Number of students assigned to each advisor')
            ->addData('nama dosen', $data)
            ->setHeight('200')
            ->setXAxis($labels);
    }
}
