<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryAdvanceController extends Controller
{

    /* KASBON
        Salary advance adalah istilah yang digunakan untuk merujuk pada uang yang diberikan kepada karyawan sebelum tanggal gajian mereka,
        yang nantinya akan dikurangi dari gaji mereka pada tanggal gajian selanjutnya.
    */

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

        $vue = true;

        return view("pages.salary-advance.index", compact("salaryAdvances", "vue"));
    }
}
