<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VacationController extends Controller
{
    // vacation = cuti
    public function index()
    {
        $vue = true;

        return view("pages.vacation.index", compact('vue'));
    }

    public function fetchData()
    {
        $vacations = [
            (object) [
                "id" => 1,
                "employee_name" => "Muhammad Adi",
            ],
        ];

        return response()->json([
            "vacations" => $vacations,
        ]);
    }
}
