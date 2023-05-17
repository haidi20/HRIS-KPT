<?php

namespace App\Http\Controllers;

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
        $projects = [
            (object)[
                "id" => 1,
                "name" => "Kapal A",
                "company_name" => "PT. Maju Jaya",
                "total_job_order" => 4,
                "total_job_order_finish" => 5,
            ]
        ];

        return response()->json([
            "projects" => $projects,
        ]);
    }
}
