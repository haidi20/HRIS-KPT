<?php

namespace App\Http\Controllers;

use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        return view("pages.master.working-hour.index", compact("id","startTime", "afterWork", "maximumDelay", "fastestTime", "overtimeWork"));
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

                $message = "dikirim";
            }

            $workingHour->start_time = request("start_time");
            $workingHour->after_work = request("after_work");
            $workingHour->maximum_delay = request("maximum_delay");
            $workingHour->fastest_time = request("fastest_time");
            $workingHour->overtime_work = request("overtime_work");
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
