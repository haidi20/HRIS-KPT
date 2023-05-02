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
        // $workingHours = WorkingHour::all();
        $workingHours = [
            [
                "type" => "hour_start",
                "value" => "08:00",
                "time_zone" => "WITA",
            ],
        ];

        return view("pages.setting.working-hour", compact("workingHours"));
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

            $workingHour->name = request("name");
            $workingHour->feature_id = request("feature_id");
            $workingHour->description = request("description");
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

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $workingHour = WorkingHour::find(request("id"));
            $workingHour->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $workingHour->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }
}
