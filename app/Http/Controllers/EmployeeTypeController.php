<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class EmployeeTypeController extends Controller
{
    public function index()
    {
        $employes_type = [
            (object)[
                "id" => 1,
                "nama_jenis" => "Tetap",
            ]
        ];

        return view("pages.master.employee-type.index", compact("employes_type"));
    }
}
