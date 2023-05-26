<?php

namespace App\Http\Controllers;

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

            // if (request("id")) {
            //     $role = Role::find(request("id"));

            //     $message = "diperbaharui";
            // } else {
            //     $role = new Role;

            //     $message = "dikirim";
            // }

            // $role->name = request("name");
            // $role->guard_name = "web";
            // $role->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil Kirim Data'], 200);
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

            // $role = Role::find(request("id"));
            // $role->update([
            //     'deleted_by' => request("user_id"),
            // ]);
            // $role->delete();

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
