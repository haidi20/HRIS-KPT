<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BargeController extends Controller
{
    public function index()
    {
        $barges = [
            (object)[
                "id" => 1,
                "nama" => "TB. 1",
                "keterangan" => "Kapal TB 1",
            ]
        ];

        return view("pages.master.barge.index", compact("barges"));
    }
}
