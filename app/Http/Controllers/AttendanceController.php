<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $vue = true;

        return view("pages.attendance.index", compact("vue"));
    }
}
