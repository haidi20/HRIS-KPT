<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobOrderReportController extends Controller
{
    public function index()
    {
        $vue = true;

        return view("pages.job-order-report.index", compact("vue"));
    }
}
