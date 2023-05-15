<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VacationController extends Controller
{
    // vacation = cuti
    public function index()
    {
        $vue = true;

        return view("pages.vacation.index", compact('vue'));
    }

    public function fetchData()
    {
        $vacations = [
            (object) [
                "id" => 1,
                "employee_name" => "Muhammad Adi",
            ],
        ];

        return response()->json([
            "vacations" => $vacations,
        ]);
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $vacation = Vacation::find(request("id"));

                $message = "diperbaharui";
            } else {
                $vacation = new Vacation;

                $message = "dikirim";
            }

            $vacation->employee_id = request("employee_id");
            $vacation->date_start = request("date_start");
            $vacation->date_end = request("date_end");
            $vacation->note = request("note");
            $vacation->save();

            DB::commit();

            return response()->json([
                'success' => true,
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

            $vacation = Vacation::find(request("id"));
            $vacation->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $vacation->delete();

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
