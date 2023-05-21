<?php

namespace App\Http\Controllers;

use App\Models\FingerTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class FingerToolController extends Controller
{
    public function index()
    {
        $finger_tools = FingerTool::all();

        return view("pages.master.finger-tool.index", compact("finger_tools"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $finger_tool = FingerTool::find(request("id"));
                $finger_tool->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $finger_tool = new FingerTool;
                $finger_tool->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $finger_tool->name = request("name");
            $finger_tool->serial_number = request("serial_number");
            $finger_tool->save();

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

            $finger_tool = FingerTool::find(request("id"));
            $finger_tool->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $finger_tool->delete();

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
