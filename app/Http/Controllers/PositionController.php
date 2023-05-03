<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = [
            (object)[
                "id" => 1,
                "name" => "HRD",
            ]
        ];

        return view("pages.master.position.index", compact("positions"));
    }
}
