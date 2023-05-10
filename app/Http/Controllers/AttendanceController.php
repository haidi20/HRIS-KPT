<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AttendanceController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.attendance.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $result = [];
        $date = Carbon::parse(request("date_filter"));
        $dateRange = $this->dateRange($date->format("Y-m"));

        $rosters = [
            (object)[
                "id" => 1,
                "id_finger" => 04,
                "employee_name" => "Muhammad Adi",
                "department_name" => "Welder",
            ]
        ];

        foreach ($rosters as $key => $item) {
            $mainData = [];
            $mainData['id'] = $item->id;
            $mainData['id_finger'] = $item->id_finger;
            $mainData['employee_name'] = $item->employee_name;
            $mainData['department_name'] = $item->department_name;

            foreach ($dateRange as $index => $date) {
                $mainData[$date] = (object) [
                    "hour_start" => "08:00",
                    "hour_end" => "16:30",
                ];
            }

            array_push($result, $mainData);
        }

        return response()->json([
            "data" => $result,
            "dateRange" => $dateRange,
        ]);
    }
}
