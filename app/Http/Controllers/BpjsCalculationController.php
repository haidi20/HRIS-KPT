<?php

namespace App\Http\Controllers;

use App\Models\BpjsCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class BpjsCalculationController extends Controller
{
    public function index()
    {
        $bpjs_calculations = BpjsCalculation::all();

        return view("pages.setting.bpjs-calculation", compact("bpjs_calculations"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $bpjs_calculation = BpjsCalculation::find(request("id"));
                $bpjs_calculation->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $bpjs_calculation = new BpjsCalculation;
                $bpjs_calculation->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $bpjs_calculation->name = request("name");
            $bpjs_calculation->company_percent = request("company_percent");
            $bpjs_calculation->company_nominal = request("company_nominal");
            $bpjs_calculation->save();

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

            $bpjs_calculation = BpjsCalculation::find(request("id"));
            $bpjs_calculation->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $bpjs_calculation->delete();

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
