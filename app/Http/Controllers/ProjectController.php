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
        $projects = Project::orderBy("name", "desc")->get();

        return response()->json([
            "projects" => $projects,
        ]);
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
