<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobOrderReportController extends Controller
{
    public function index()
    {
        $jobOrders = [
            (object)[
                "id" => 1,
                "code" => "",
                "project_name" => "Kapal A",
                "job_order_category_name" => "Harian",
                "job_code" => "SC002",
                "job_name" => "Pemakaian Docking Area Per Hari",
                "job_note" => "pemakaian docking A",
                "level" => "mudah",
                "time_type" => "day",
                "date_time_start" => "Jum'at, 04 Mei 2023",
                "date_time_end" => "Jum'at, 05 Mei 2023",
                "duration" => "2 hari",
                "note" => "segera di selesaikan",
            ]
        ];

        return view("pages.job-order-report.index", compact("jobOrders"));
    }
}
