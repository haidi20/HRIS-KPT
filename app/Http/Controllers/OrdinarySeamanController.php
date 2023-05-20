<?php

namespace App\Http\Controllers;

use App\Models\OrdinarySeamans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdinarySeamanController extends Controller
{
    public function fetchData()
    {
        $ordinarySeamans = OrdinarySeamans::all();

        return response()->json([
            "ordinarySeamans" => $ordinarySeamans,
        ]);
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $ordinarySeaman = OrdinarySeamans::find(request("id"));

                $message = "diperbaharui";
            } else {
                $ordinarySeaman = new OrdinarySeamans;

                $message = "dikirim";
            }

            $ordinarySeaman->name = request("name");
            // $ordinarySeaman->address = request("address");
            // $ordinarySeaman->no_hp = request("no_hp");
            $ordinarySeaman->save();

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

            $ordinarySeaman = OrdinarySeamans::find(request("id"));
            $ordinarySeaman->update([
                'deleted_by' => request("user_id"),
            ]);
            $ordinarySeaman->delete();

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
