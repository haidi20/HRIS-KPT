<?php

namespace App\Http\Controllers;

use App\Exports\VacationReportExport;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class VacationReportController extends Controller
{
    public function index()
    {
        $dateStart = Carbon::now()->startOfMonth();
        $dateEnd = Carbon::now()->endOfMonth();

        return view("pages.vacation-report.index", compact("dateStart", "dateEnd"));
    }

    public function fetchData()
    {
        $dateStart = Carbon::parse(request("date_start"));
        $dateEnd = Carbon::parse(request("date_end"));

        $vacations = Vacation::whereDate("date_start", ">=", $dateStart->format("Y-m-d"))
            ->whereDate("date_start", "<=", $dateEnd->format("Y-m-d"))
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json([
            "dateStart" => $dateStart->format("Y-m-d"),
            "dateEnd" => $dateEnd->format("Y-m-d"),
            "vacations" => $vacations,
        ]);
    }

    public function export()
    {
        $dateStart = Carbon::parse(request("date_start"));
        $dateStartReadable = $dateStart->isoFormat("dddd, D MMMM YYYY");
        $dateEnd = Carbon::parse(request("date_end"));
        $dateEndReadable = $dateEnd->isoFormat("dddd, D MMMM YYYY");
        $data = $this->fetchData()->original["vacations"];
        $nameFile = "cuti_{$dateStartReadable}-{$dateEndReadable}.xlsx";

        try {
            Excel::store(new VacationReportExport($data), $nameFile, 'real_public', \Maatwebsite\Excel\Excel::XLSX);

            return response()->json([
                "success" => true,
                "data" => $data,
                "linkDownload" => route('project.download', ["name_file" => $nameFile]),
            ]);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal export data',
            ], 500);
        }
    }

    public function download()
    {
        $path = public_path(request("name_file"));

        return Response::download($path);
    }
}