<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PositionController extends Controller
{
     public function index()
    {
        $positions = Position::all();

        return view("pages.master.position.index", compact("positions"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $position = Position::find(request("id"));
                $position->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $position = new Position;
                $position->created_by = Auth::user()->id;

                $message = "dikirim";
            }

            $position->name = request("name");
            $position->description = request("description");
            $position->minimum_employee = request("minimum_employee");
            $position->save();

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

            $position = Position::find(request("id"));
            $position->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $position->delete();

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
