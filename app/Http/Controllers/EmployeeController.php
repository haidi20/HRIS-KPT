<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    public function index()
    {
        $employes = [
            (object)[
                "id" => 1,
                "nip" => "KPT0123",
                "name" => "SALDIN",
                "jabatan" => "NAHKODA",
                "lokasi_kerja" => "CREWING",
                "kapal" => "TB. SATRIA 1",
                "status" => "Aktif",
            ]
        ];

        return view("pages.master.employee.index", compact("employes"));
    }
}
