<?php

namespace App\Http\Controllers;

use App\Models\EmployeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class EmployeeTypeController extends Controller
{
    public function index()
    {
        $employeetypes = EmployeeType::all();

        return view("pages.master.employee-type.index", compact("employeetypes"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $employeetype = EmployeeType::find(request("id"));
                $employeetype->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $employeetype = new EmployeeType;
                $employeetype->created_by = Auth::user()->id;

                $message = "dikirim";
            }

            $employeetype->name = request("name");
            $employeetype->description = request("description");
            $employeetype->save();

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

            $employeetype = EmployeeType::find(request("id"));
            $employeetype->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $employeetype->delete();

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
