<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
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

        return view("pages.project.index", compact("projects"));
    }
}
