<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryAdvanceReportController extends Controller
{
    // LAPORAN KASBON
    public function index()
    {
        $salaryAdvances = [
            (object)[
                "id" => 1,
                "employee_name" => "Muhammad Adi",
                "amount" => "5.000.000",
                "monthly_deduction" => "1.000.000",
                "duration" => "5 bulan",
                "net_salary" => "4.000.000",
                "remaining_debt" => "1.200.000",
                "date" => "Jum'at, 5 Mei 2023",
                "status" => "accept",
            ],
        ];

        return view("pages.salary-advance-report.index", compact("salaryAdvances"));
    }
}
