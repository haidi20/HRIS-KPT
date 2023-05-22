<?php

namespace App\Http\Controllers;

use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class WorkingHourController extends Controller
{
    public function index()
    {
        $id = WorkingHour::pluck('id');
        $startTime = WorkingHour::pluck('start_time');
        $afterWork = WorkingHour::pluck('after_work');
        $maximumDelay = WorkingHour::pluck('maximum_delay');
        $fastestTime = WorkingHour::pluck('fastest_time');
        $overtimeWork = WorkingHour::pluck('overtime_work');
        $saturdayWorkHour = WorkingHour::pluck('saturday_work_hour');

        return view("pages.master.working-hour.index", compact("id", "startTime", "afterWork", "maximumDelay", "fastestTime", "overtimeWork", "saturdayWorkHour"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $workingHour = WorkingHour::find(request("id"));

                $message = "diperbaharui";
            } else {
                $workingHour = new WorkingHour;

                $message = "ditambahkan";
            }

            $start_time = Carbon::createFromFormat('H:i', request('start_time'))->format('H:i');
            $after_work = Carbon::createFromFormat('H:i', request('after_work'))->format('H:i');
            $maximum_delay = Carbon::createFromFormat('H:i', request('maximum_delay'))->format('H:i');
            $fastest_time = Carbon::createFromFormat('H:i', request('fastest_time'))->format('H:i');
            $overtime_work = Carbon::createFromFormat('H:i', request('overtime_work'))->format('H:i');
            $saturday_work_hour = Carbon::createFromFormat('H:i', request('saturday_work_hour'))->format('H:i');

            $workingHour->start_time = $start_time;
            $workingHour->after_work = $after_work;
            $workingHour->maximum_delay = $maximum_delay;
            $workingHour->fastest_time = $fastest_time;
            $workingHour->overtime_work = $overtime_work;
            $workingHour->saturday_work_hour = $saturday_work_hour;
            $workingHour->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [],
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => "Gagal {$message}",
            ], 500);
        }
    }
}
