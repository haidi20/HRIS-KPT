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
                "name" => "pembaikan mesin utama",
            ]
        ];

        return response()->json([
            "jobOrders" => $jobOrders,
        ]);
    }
}
