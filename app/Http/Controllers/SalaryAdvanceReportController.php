<?php

namespace App\Http\Controllers;

use App\Models\SalaryAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;

class SalaryAdvanceReportController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.salary-advance-report.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {

        $salaryAdvances = SalaryAdvance::orderBy("created_at", "desc")->get();

        return response()->json([
            "salaryAdvances" => $salaryAdvances,
        ]);
    }

    // LAPORAN KASBON
    public function indexOld()
    {

        // selanjutnya pindah ke fetchData dapatkan datanya.
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
                "reason" => "kebutuhan beli handphone baru",
            ],
        ];

        return view("pages.salary-advance-report.index", compact("salaryAdvances"));
    }
}
