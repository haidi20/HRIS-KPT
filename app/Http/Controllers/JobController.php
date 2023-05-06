<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = [
            (object)[
                "id" => 1,
                "kode" => "123",
                "nama_job" => "Reguler",
                "keterangan" => "Job Reguler",
            ]
        ];

        return view("pages.master.job.index", compact("jobs"));
    }
}
