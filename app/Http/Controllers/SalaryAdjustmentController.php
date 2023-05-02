<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalaryAdjustmentController extends Controller
{
    public function index()
    {
        $salaryAdjustments = [
            (object)[
                "id" => 1,
                "name" => "Naik Kapal",
            ],
        ];
        // $salaryAdjustments = $salaryAdjustments->toJson();

        // return $salaryAdjustments;

        return view("pages.setting.salary-adjustment", compact("salaryAdjustments"));
    }

    public function store(Request $request)
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
