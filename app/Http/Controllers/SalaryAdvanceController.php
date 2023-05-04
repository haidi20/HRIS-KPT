<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryAdvanceController extends Controller
{
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
                "date" => "Jum'at, 5 Mei 2023",
            ]
        ];

        return view("pages.salary-advance.index", compact("salaryAdvances"));
    }
}
