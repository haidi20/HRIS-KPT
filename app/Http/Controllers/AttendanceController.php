<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class AttendanceController extends Controller
{
    public $path = 'export\absensi.xlsx';

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.attendance.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchDataMain()
    {
        $result = [];
        $positionId = request("position_id");
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $dateRange = $this->dateRange($month->format("Y-m"));

        $rosters = [
            (object)[
                "id" => 1,
                "id_finger" => 04,
                "employee_name" => "Muhammad Adi",
                "position_name" => "Welder",
            ]
        ];

        foreach ($rosters as $key => $item) {
            $mainData = [];
            $mainData['id'] = $item->id;
            $mainData['id_finger'] = $item->id_finger;
            $mainData['employee_name'] = $item->employee_name;
            $mainData['position_name'] = $item->position_name;

            foreach ($dateRange as $index => $date) {
                $mainData[$date] = (object) [
                    "hour_start" => "08:00",
                    "hour_rest_start" => "12:00",
                    "hour_rest_end" => "13:00",
                    "hour_end" => "17:00",
                ];
            }

            array_push($result, $mainData);
        }

        return response()->json([
            "data" => $result,
            "dateRange" => $dateRange,
        ]);
    }

    public function fetchDataDetail()
    {
        $result = [];
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $dateRange = $this->dateRangeCustom($month, "d", "object", true);

        foreach ($dateRange as $index => $date) {
            $row = (object) [
                "date" => $date->date,
                "day" => $date->day, // Add the value for "day"
                "hour_start" => "", // Add the value for "hour_start"
                "hour_end" => "", // Add the value for "hour_end"
                "duration" => "", // Add the value for "duration"
                "hour_rest_start" => "", // Add the value for "hour_rest_start"
                "hour_rest_end" => "", // Add the value for "hour_rest_end"
                "duration_hour_work" => "", // Add the value for "duration_hour_work"
            ];

            array_push($result, $row);
        }

        return response()->json([
            "data" => $result,
            "monthReadAble" => $monthReadAble,
        ]);
    }

    public function export()
    {
        $totalRoster = [];
        $data = $this->fetchData()->original["data"];
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $dateRange = $this->dateRange($month->format("Y-m"));

        // foreach ($rosterStatsuses as $key => $value) {
        //     $totalRoster[$value->initial] = $this->fetchTotalRoster($value->initial)->original["data"];
        // }
        // $totalRoster["ALL"] = $this->fetchTotalRoster("ALL")->original["data"];

        try {
            Excel::store(new AttendanceExport($data, $dateRange), $this->path, 'real_public', \Maatwebsite\Excel\Excel::XLSX);

            return response()->json([
                "success" => true,
                "data" => $data,
                "linkDownload" => route('attendance.download'),
            ]);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal export data',
            ], 500);
        }
    }

    public function download()
    {
        $path = public_path($this->path);

        return Response::download($path);
    }

    public function print()
    {
        $data = $this->fetchDataDetail()->original["data"];

        // return $data;

        return view("pages.attendance.partials.print", compact("data"));
    }
}
