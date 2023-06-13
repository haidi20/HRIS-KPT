<?php

namespace App\Http\Controllers;

use App\Models\JobStatusHasParent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class OvertimeReportController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.overtime-report.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $nameModel = "App\Models\JobOrderHasEmployee";
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $overtimes = JobStatusHasParent::where(["status" => "overtime"])
            ->whereYear("datetime_start", $month->format("Y"))
            ->whereMonth("datetime_start", $month->format("m"))
            ->get();

        return response()->json([
            "overtimes" => $overtimes,
            "monthReadAble" => $monthReadAble,
        ]);
    }

    private function fetchDataOld()
    {
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");

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

        return response()->json([
            "overtimes" => $overtimes,
            "monthReadAble" => $monthReadAble,
        ]);
    }
}
