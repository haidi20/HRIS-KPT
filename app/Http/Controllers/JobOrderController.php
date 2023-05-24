<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function index()
    {
        $vue = true;

        return view("pages.job-order.index", compact("vue"));
    }

    public function fetchData()
    {

        $jobOrders = [
            (object)[
                "id" => 1,
                "proyek_name" => "Project A",
                "job_name" => "Bongkar pasang cuttleas bearing",
                // jenis waktunya hari maka tanggal saja, jika menit dan jam maka tanggal dan jam
                "time_end_readable" => "Selasa 1 Juni 2023",
            ]
        ];

        return response()->json([
            "jobOrders" => $jobOrders,
            "project_id" => request("project_id"),
        ]);
    }
}
