<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index()
    {
        $overtimes = [
            (object)[
                "id" => 1,
                "name" => "Muhammad Adi",
                "job_order_name" => "Perbaikan Mesin",
                "duration" => "3 Jam",
                "date_time_start" => "Jum'at, 05 Mei 2023 17:00",
                "date_time_end" => "Jum'at, 05 Mei 2023 20:00",
            ]
        ];

        return view("pages.overtime.index", compact("overtimes"));
    }
}
