<?php

namespace App\Charts;

use App\Models\Lecturer;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class LecturersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {   
        $data = [
            Lecturer::whereHas('user', function ($query) {
                $query->where('gender', 'male');
            })->count(),
            Lecturer::whereHas('user', function ($query) {
                $query->where('gender', 'female');
            })->count(),
        ];
        
        $label = [
            'Male',
            'Female'
        ];

        return $this->chart->pieChart()
            ->setTitle('Distribution of Lecturers by Gender.')
            ->addData($data)
            ->setHeight(200)
            ->setLabels($label);
    }
}
