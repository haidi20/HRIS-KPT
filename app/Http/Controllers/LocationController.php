<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view("pages.master.location.index", compact("locations"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $location = Location::find(request("id"));
                $location->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $location = new Location;
                $location->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $location->name = request("name");
            $location->description = request("description");
            $location->save();

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

            $location = Location::find(request("id"));
            $location->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $location->delete();

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
