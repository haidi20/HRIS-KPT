<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function index()
    {
        $jobOrders = [
            (object)[
                "id" => 1,
                "name" => "pembaikan mesin utama",
            ]
        ];

        $vue = true;

        return view("pages.job-order.index", compact("vue", "jobOrders"));
    }
}
