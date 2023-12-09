<?php

namespace App\Http\Controllers;

use App\Charts\UsersChart;
use App\Charts\StudentsChart;
use App\Charts\LecturersChart;
use App\Charts\ProposalsChart;
use App\Charts\StudentAdvisorAssignmentChart;

class DashboardController extends Controller
{
    public function index(LecturersChart $lecturersChart, StudentsChart $studentsChart, ProposalsChart $proposalsChart, UsersChart $usersChart, StudentAdvisorAssignmentChart $studentAdvisorAssignmentChart)
    {
        return view('dashboard', [
            'lecturersChart'                => $lecturersChart->build(),
            'studentsChart'                 => $studentsChart->build(),
            'proposalsChart'                => $proposalsChart->build(),
            'usersChart'                    => $usersChart->build(),
            'studentAdvisorAssignmentChart' => $studentAdvisorAssignmentChart->build(),
        ]);
    }
}
