<?php

namespace App\Charts;

use App\Models\Proposal;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProposalsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $dataOnProcess = [
            Proposal::where('status', 'on_process')->where('type', 'thesis')->count(),
            Proposal::where('status', 'on_process')->where('type', 'journal')->count(),
            Proposal::where('status', 'on_process')->where('type', 'appropriate_technology')->count(),
        ];

        $dataDone = [
            Proposal::where('status', 'done')->where('type', 'thesis')->count(),
            Proposal::where('status', 'done')->where('type', 'journal')->count(),
            Proposal::where('status', 'done')->where('type', 'appropriate_technology')->count(),
        ];

        return $this->chart->areaChart()
            ->setTitle('Distribution of Student Final Project Types')
            ->setSubtitle('On process VS Completed')
            ->addData('On Process', $dataOnProcess)
            ->addData('Completed', $dataDone)
            ->setHeight(200)
            ->setXAxis(['T', 'J', 'A-T']);
    }
}
