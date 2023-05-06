<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companys = [
            (object)[
                "id" => 1,
                "nama" => "CV. KPT",
                "keterangan" => "CV KPT",
            ]
        ];

        return view("pages.master.company.index", compact("companys"));
    }
}
