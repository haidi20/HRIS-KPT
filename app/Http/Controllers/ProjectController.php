<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ProjectController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.project.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $projects = Project::with(["contractors", "ordinarySeamans", "jobOrders"])->orderBy("date_end", "asc")->get();

        return response()->json([
            "projects" => $projects,
        ]);
    }

    public function store()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $project = Project::find(request("id"));

                $message = "diperbaharui";
            } else {
                $project = new Project;

                $message = "ditambahkan";
            }

            $project->name = request("name");
            $project->save();

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

            $project = Project::find(request("id"));
            $project->update([
                'deleted_by' => request("user_id"),
            ]);
            $project->delete();

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

    public function fetchDataOld()
    {
        $projects = [
            (object)[
                "id" => 1,
                "name" => "Pengerjaan Kapal A",
                "barge_name" => "Kapal A",
                "company_name" => "PT. Maju Jaya",
                "job_order_total" => 4,
                "job_order_total_finish" => 5,
            ]
        ];

        return response()->json([
            "projects" => $projects,
        ]);
    }
}
