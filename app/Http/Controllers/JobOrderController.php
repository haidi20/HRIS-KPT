<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


class JobOrderController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.job-order.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {

        $jobOrders = [
            (object)[
                'id' => 1,
                'project_id' => 1,
                'category' => "reguler",
                'category_name' => "Reguler",
                'project_name' => "Staging",
                'project_note' => "informasi lebih lengkap tentang staging",
                'status' => "active",
                'status_readable' => "Aktif",
                'employee_total' => 5,
                'employee_active_total' => 4,
                'status_color' => "success",
                'assessment_count' => 1,
                'assessment_total' => 2,
                'is_assessment_foreman' => false,
                'is_assessment_quality_control' => true,
            ],
        ];

        return response()->json([
            "jobOrders" => $jobOrders,
            "project_id" => request("project_id"),
        ]);
    }
}
