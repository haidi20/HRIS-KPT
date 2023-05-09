<?php

namespace App\Http\Controllers;

use App\Models\Roster;
use App\Models\RosterDaily;
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
        $monthReadAble = $monthFilter->isoFormat("MMMM YYYY");
        $dateRanges = $this->dateRanges($monthFilter->format("Y-m"));

        $employees = [
            (object)[
                "id" => 1,
                "id_finger" => 04,
                "employee_name" => "Muhammad Adi",
                "department_name" => "Welder",
                "work_schedule" => "5,2",
            ]
        ];

        foreach ($employees as $key => $item) {
            $mainData = [];
            $mainData['id'] = $item->id;
            $mainData['id_finger'] = $item->id_finger;
            $mainData['employee_id'] = $item->id;
            $mainData['employee_name'] = $item->employee_name;
            $mainData['department_name'] = $item->department_name;
            $mainData['work_schedule'] = $item->work_schedule;

            foreach ($dateRanges as $index => $date) {
                $rosterDaily = Roster::where(["employee_id" => $item->id])
                    ->whereDate("date", $date)
                    ->orderBy("created_at", "desc")
                    ->first();

                $mainData[$date] = [
                    "value" => $rosterDaily != null ? $rosterDaily->roster_status_initial : null,
                    "color" => $rosterDaily != null ? $rosterDaily->roster_status_color : null,
                    "date_start" => $rosterDaily != null ? $rosterDaily->date_start : null,
                    "date_end" => $rosterDaily != null ? $rosterDaily->date_end : null,
                ];
            }

            array_push($result, $mainData);
        }

        return response()->json([
            "data" => $result,
            "dateRanges" => $dateRanges,
            "monthReadAble" => $monthReadAble,
        ]);
    }

    public function store()
    {
        $getData = (object) [
            "employee_id" => request("employee_id"),
            "employee_name" => request("employee_name"),
            "work_schedule" => request("work_schedule"),
            "day_off_one" => request("day_off_one"),
            "day_off_two" => request("day_off_two"),
            "month" => request("month"),
            "date_vacation" => request("date_vacation"),
        ];

        // return response()->json([
        //     'success' => true,
        //     'getData' => $getData,
        //     'message' => "Berhasil ditambahkan",
        // ], 200);

        try {
            DB::beginTransaction();

            // store off one
            $this->storeOff($getData, "day_off_one");

            // insert data cuti
            $this->storeVacation($getData);

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

    private function storeVacation($getData)
    {
        $rosterStatusId = RosterStatus::where("initial", "C")->first()->id;
        $rosterDailyData = [];

        $start = Carbon::parse($getData->date_vacation[0]);
        $end = Carbon::parse($getData->date_vacation[1]);

        while ($start->lte($end)) {
            $rosterDailyData[] = ["date" => $start->format('Y-m-d')];
            $start->addDay();
        }

        foreach ($rosterDailyData as $index => $item) {
            RosterDaily::updateOrCreate(
                [
                    "employee_id" => $getData->employee_id,
                    "date" => $item["date"],
                ],
                [
                    "roster_status_id" => $rosterStatusId,
                ]
            );
        }
    }

    private function storeOff($getData, $nameObject)
    {
        $rosterStatusId = RosterStatus::where("initial", "OFF")->first()->id;
        $getDatesOffOne = $this->getDatesByDayName($getData->day_off_one, $getData->month);

        foreach ($getDatesOffOne as $index => $item) {
            RosterDaily::updateOrCreate(
                [
                    "employee_id" => $getData->employee_id,
                    "date" => $item,
                ],
                [
                    "roster_status_id" => $rosterStatusId,
                ]
            );
        }
    }
}
