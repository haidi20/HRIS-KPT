<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class BargeController extends Controller
{
    public function index()
    {
        $barges = Barge::all();

        return view("pages.master.barge.index", compact("barges"));
    }

    public function fetchData()
    {
        $barges = Barge::orderBy("name", "asc")->get();

        return response()->json([
            "barges" => $barges,
        ]);
    }


    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $barge = Barge::find(request("id"));
                $barge->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $barge = new Barge;
                $barge->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $barge->name = request("name");
            $barge->description = request("description");
            $barge->save();

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

            $barge = Barge::find(request("id"));
            $barge->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $barge->delete();

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
