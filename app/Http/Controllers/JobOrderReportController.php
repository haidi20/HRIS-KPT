<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JobOrderReportController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.job-order-report.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $dateStart = Carbon::parse(request("date_start"));
        $dateEnd = Carbon::parse(request("date_end"));
        $jobOrders = JobOrder::whereDate("datetime_start", ">=", $dateStart)
            ->whereDate("datetime_start", "<=", $dateEnd)
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json([
            "jobOrders" => $jobOrders,
        ]);
    }

    private function fetchDataOld()
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

        return response()->json([
            "jobOrders" => $jobOrders,
        ]);
    }
}
