<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function monthly()
    {
        $month = Carbon::now();
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $employees =  [
            (object)[
                "id" => 1,
                "name" => "AVET ATAN",
            ],
            (object)[
                "id" => 2,
                "name" => "MUHAMMAD ADI",
            ],
        ];

        $data = (object) [
            //
        ];

        return view("pages.payroll.monthly", compact(
            "data",
            "month",
            "employees",
            "monthNow",
        ));
    }

    public function fetchSalary()
    {
        $month = Carbon::parse(request("month_filter", Carbon::now()));
        $monthNow = $month->format("Y-m");
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $employee =  (object)[
            "id" => 1,
            "name" => "AVET ATAN",
            "number_identity" => "112201001",
            "position_name" => "DRIVER",
            "salary" => "3.394.000",
            "tunjangan_tetap" => "",
            "rate_lembur" => "19.618",
            "tunjangan_makan" => "12.000",
            "tunjangan_transportasi" => "-",
            "tunjangan_kehadiran" => "-",
            "ptkp_karyawan" => "-",
            "jumlah_cuti_ijin" => "-",
            "sisa_cuti" => "-",
        ];

        return response()->json([
            "employee" => $employee,
            "monthReadAble" => $monthReadAble,
        ]);
    }
}
