<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        return view("pages.setting.feature", compact("features"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $feature = Feature::find(request("id"));
                $feature->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $feature = new Feature;
                $feature->created_by = Auth::user()->id;

                $message = "dikirim";
            }

            $feature->name = request("name");
            $feature->description = request("description");
            $feature->save();

            $tasks = ["lihat", "tambah", "edit", "hapus"];

            foreach ($tasks as $task) {
                $name = strtolower($feature->name);
                $featureDescription = str_replace('-', ' ', strtolower($feature->name));

                Permission::updateOrCreate(
                    [
                        "feature_id" => $feature->id,
                        "name" => "{$task} {$name}",
                    ],
                    [
                        "description" => "{$task} {$featureDescription}",
                        "guard_name" => "web",
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [],
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

            $feature = Feature::find(request("id"));
            $feature->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $feature->delete();

            Permission::where("feature_id", request("id"))
                ->delete();

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
