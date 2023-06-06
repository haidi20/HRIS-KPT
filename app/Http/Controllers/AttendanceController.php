<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\AttendanceFingerspot;
use App\Models\FingerTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class AttendanceController extends Controller
{
    public $path = 'export\absensi.xlsx';
    public $fingerTools = [];

    function __construct()
    {
        $this->fingerTools = [
            (object) [
                "cloud_id" => "C26118515714322D",
                "serial_number" => "Fio66208022030036",
            ],
        ];
    }

    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.attendance.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchDataMain()
    {
        $result = [];
        $positionId = request("position_id");
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $dateRange = $this->dateRange($month->format("Y-m"));

        $rosters = [
            (object)[
                "id" => 1,
                "id_finger" => 04,
                "employee_name" => "Muhammad Adi",
                "position_name" => "Welder",
            ]
        ];

        foreach ($rosters as $key => $item) {
            $mainData = [];
            $mainData['id'] = $item->id;
            $mainData['id_finger'] = $item->id_finger;
            $mainData['employee_name'] = $item->employee_name;
            $mainData['position_name'] = $item->position_name;

            foreach ($dateRange as $index => $date) {
                $mainData[$date] = (object) [
                    "hour_start" => "08:00",
                    "hour_rest_start" => "12:00",
                    "hour_rest_end" => "13:00",
                    "hour_end" => "17:00",
                ];
            }

            array_push($result, $mainData);
        }

        return response()->json([
            "data" => $result,
            "dateRange" => $dateRange,
        ]);
    }

    public function fetchDataDetail()
    {
        $result = [];
        $employeeId = request("employee_id");
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");

        $dateRange = $this->dateRangeCustom($month, "d", "object", true);

        foreach ($dateRange as $index => $date) {
            $row = (object) [
                "date" => $date->date,
                "day" => $date->day, // Add the value for "day"
                "hour_start" => "", // Add the value for "hour_start"
                "hour_end" => "", // Add the value for "hour_end"
                "duration" => "", // Add the value for "duration"
                "hour_rest_start" => "", // Add the value for "hour_rest_start"
                "hour_rest_end" => "", // Add the value for "hour_rest_end"
                "duration_hour_work" => "", // Add the value for "duration_hour_work"
            ];

            array_push($result, $row);
        }

        return response()->json([
            "data" => $result,
            "monthReadAble" => $monthReadAble,
        ]);
    }

    public function export()
    {
        $totalRoster = [];
        $data = $this->fetchData()->original["data"];
        $month = Carbon::parse(request("month"));
        $monthReadAble = $month->isoFormat("MMMM YYYY");
        $dateRange = $this->dateRange($month->format("Y-m"));

        // foreach ($rosterStatsuses as $key => $value) {
        //     $totalRoster[$value->initial] = $this->fetchTotalRoster($value->initial)->original["data"];
        // }
        // $totalRoster["ALL"] = $this->fetchTotalRoster("ALL")->original["data"];

        try {
            Excel::store(new AttendanceExport($data, $dateRange), $this->path, 'real_public', \Maatwebsite\Excel\Excel::XLSX);

            return response()->json([
                "success" => true,
                "data" => $data,
                "linkDownload" => route('attendance.download'),
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
        $path = public_path($this->path);

        return Response::download($path);
    }

    public function print()
    {
        $data = $this->fetchDataDetail()->original["data"];

        // return $data;

        return view("pages.attendance.partials.print", compact("data"));
    }

    public function storeFingerSpot()
    {
        $fingerTools = FingerTool::all();
        $dateNow = Carbon::now()->format("Y-m-d");
        $dateStart = request("date_start", $dateNow);
        $dateEnd = request("date_end", $dateStart);

        $responseData = [];
        $url = "https://developer.fingerspot.io/api/get_attlog";

        foreach ($fingerTools as $index => $item) {
            if ($item->cloud_id == null) {
                continue;
            }

            $data = [
                "trans_id" => "1",
                "cloud_id" => $item->cloud_id,
                "start_date" => $dateStart,
                "end_date" => $dateEnd,
            ];
            $headers = [
                "Authorization: Bearer R7Y9BW9KPPT36P36",
                "Content-Type: application/json"
            ];

            $options = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $headers,
            ];

            $curl = curl_init();
            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            curl_close($curl);

            if ($response === false) {
                // Error occurred
                $error = curl_error($curl);
                echo "Error: " . $error;
            } else {
                // Process the response
                // $responseData = json_decode($response, true);
                $response = json_decode($response, true);
                foreach ($response["data"] as $key => $value) {
                    $data = [
                        "pin" => $value["pin"],
                        "scan_date" => $value["scan_date"],
                        "cloud_id" => $item->cloud_id,
                        "status_scan" => $value["status_scan"],
                        "verify" => $value["verify"],
                    ];

                    array_push($responseData, $data);
                }
                // Handle the response data accordingly
            }
        }

        foreach ($responseData as $index => $item) {
            AttendanceFingerspot::updateOrCreate([
                "pin" => $item['pin'],
                "scan_date" => $item['scan_date'],
                "cloud_id" => $item['cloud_id'],
            ], [
                "status_scan" => $item['status_scan'],
                "verify" => $item['verify'],
            ]);
        }

        return response()->json([
            "dateStart" => $dateStart,
            "data" => $responseData,
        ]);
    }

    public function storeHasEmployee()
    {
        $dateNow = Carbon::now()->format("Y-m-d");
        $date = request("date", $dateNow);

        $query = "CALL SP_ATTENDANCE_HAS_EMPLOYEES('{$date}')";
        $result = DB::select($query);

        return response()->json([
            "date" => $date,
            "data" => $result,
        ]);
    }
}
