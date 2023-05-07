<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimeReportController extends Controller
{
    public function index()
    {
        $overtimes = [
            (object)[
                "id" => 1,
                "employee_name" => "Muhammad Adi",
                "position_name" => "Welder",
                "job_order_code" => "jo001",
                "job_order_name" => "Perbaikan Mesin",
                "date_time_start" => "Jum'at, 05 Mei 2023 17:00",
                "date_time_end" => "Jum'at, 05 Mei 2023 20:00",
                "duration" => "3 Jam",
                "note" => "menyelesaikan perbaikan yang tinggal dikit selesai."
            ],
        ];

        return view("pages.overtime-report.index", compact("overtimes"));
    }
}
