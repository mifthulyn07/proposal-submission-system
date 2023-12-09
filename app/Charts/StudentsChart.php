<?php

namespace App\Charts;

use App\Models\Student;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StudentsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $data = [
            Student::whereHas('user', function ($query) {
                $query->where('gender', 'male');
            })->count(),
            Student::whereHas('user', function ($query) {
                $query->where('gender', 'female');
            })->count(),
        ];

        $label = [
            'Male',
            'Female'
        ];
        
        return $this->chart->pieChart()
            ->setTitle('Distribution of Students by Gender.')
            ->addData($data)
            ->setHeight(200)
            ->setLabels($label);
    }
}
