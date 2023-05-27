<?php

namespace App\Http\Controllers;

use App\Models\salaryAdjustment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class SalaryAdjustmentController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.setting.salary-adjustment", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $salaryAdjustments = [
            (object)[
                "id" => 1,
                "name" => "Naik Kapal",
                "time" => "Mei 2023",
                "amount" => "1.000.000",
                "type_adjustment_name" => "penambahan",
                "note" => "bonus turun kapal",
            ],
        ];

        return response()->json([
            "salaryAdjustments" => $salaryAdjustments,
        ]);
    }

    public function store()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $salaryAdjustment = salaryAdjustment::find(request("id"));

                $message = "diperbaharui";
            } else {
                $salaryAdjustment = new salaryAdjustment;

                $message = "dikirim";
            }

            $salaryAdjustment->name = request("name");
            $salaryAdjustment->type_time = request("type_time");
            $salaryAdjustment->is_date_end = request("is_date_end", false);
            $salaryAdjustment->date_start = request("date_start");
            $salaryAdjustment->date_end = request("date_end");
            $salaryAdjustment->type_amount = request("type_amount");
            $salaryAdjustment->amount = request("amount");
            $salaryAdjustment->type_adjustment = request("type_adjustment");
            $salaryAdjustment->note = request("note");
            $salaryAdjustment->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => request()->all(),
                'message' => 'Berhasil Kirim Data',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Maaf, gagal kirim data'], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            // $salaryAdjustment = salaryAdjustment::find(request("id"));
            // $salaryAdjustment->update([
            //     'deleted_by' => request("user_id"),
            // ]);
            // $salaryAdjustment->delete();

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
