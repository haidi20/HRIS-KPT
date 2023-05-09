<?php

namespace App\Http\Controllers;

use App\Models\Roster;
use App\Models\RosterStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class RosterController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.roster.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $result = [];
        $monthFilter = Carbon::parse(request("month_filter"));
        $dateRange = $this->dateRange($monthFilter->format("Y-m"));

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
                    "roster_status_initial" => "M",
                ];
            }

            array_push($result, $mainData);
        }

        return response()->json([
            "data" => $result,
        ]);
    }

    public function store()
    {
        $getData = (object) [
            "user_id" => request("user_id"),
            "date_start" => request("date_start"),
            "date_end" => request("date_end"),
            "employee_id" => request("employee_id"),
            "roster_status" => request("roster_status"),
        ];

        try {
            DB::beginTransaction();

            $rosterStatusId = RosterStatus::where("initial", $getData->roster_status)->first()->id;

            $rosterDailyData = [];

            for ($i = 1; $i < count(request("date")); $i++) {
                $start = Carbon::parse($getData->date_start);
                $end = Carbon::parse($getData->date_end);

                while ($start->lte($end)) {
                    $rosterDailyData[] = ["date" => $start->format('Y-m-d'), "roster_status" => request("roster_status")[$i]];
                    $start->addDay();
                }
            }

            foreach ($rosterDailyData as $index => $item) {
                $rosterStatusId = RosterStatus::where("initial", $item["roster_status"])->first()->id;

                Roster::updateOrCreate(
                    [
                        "employee_id" => request("employee_id"),
                        "date" => $item["date"],
                    ],
                    [
                        "roster_status_id" => $rosterStatusId,
                        // "created_by" => request("user_id"),
                    ]
                );
            }

            DB::commit();

            // create roster history

            return response()->json([
                'success' => true,
                'data' => request()->all(),
                'message' => "Berhasil ditambahkan",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            // create roster history

            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan',
            ], 500);
        }

        return response()->json([
            "request" => $getData,
        ]);
    }
}
