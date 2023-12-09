<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $data = [
            User::whereHas('roles', function ($query) {
                $query->where('name', 'kaprodi');
            })->count(),
            User::whereHas('roles', function ($query) {
                $query->where('name', 'coordinator');
            })->count(),
            User::whereHas('roles', function ($query) {
                $query->where('name', 'lecturer');
            })->count(),
            User::whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->count(),
        ];
        
        return $this->chart->donutChart()
            ->setTitle('Distribution of Users by Role.')
            ->addData($data)
            ->setHeight(200)
            ->setLabels(['Kaprodi', 'Coordinator', 'Lecturer', 'Student',]);
    }
}
