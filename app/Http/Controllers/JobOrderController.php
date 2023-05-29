<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


class JobOrderController extends Controller
{
    public function index()
    {
        $vue = true;
        $baseUrl = Url::to('/');
        $user = auth()->user();

        return view("pages.job-order.index", compact("vue", "user", "baseUrl"));
    }

    public function fetchData()
    {
        $month = Carbon::parse(request("month"));

        $jobOrders = JobOrder::with(["jobOrderDetails", "jobOrderAssessments"])
            ->whereYear("date_time", $month->format("Y"))
            ->whereMonth("date_time", $month->format("m"))
            ->orderBy("date_time", "asc")->get();

        return response()->json([
            "jobOrders" => $jobOrders,
        ]);
    }

    public function store()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $jobOrder = JobOrder::find(request("id"));

                $message = "diperbaharui";
            } else {
                $jobOrder = new JobOrder;

                $message = "ditambahkan";
                $jobOrder->status = "active";
            }

            $jobOrder->project_id = request("project_id");
            $jobOrder->date_time = Carbon::parse(request("date") . ' ' . request("hour"));
            $jobOrder->category = request("category");
            $jobOrder->save();

            // $this->storeContractors($jobOrder);
            // $this->storeOrdinarySeamans($jobOrder);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => "Gagal {$message}",
            ], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $jobOrder = JobOrder::find(request("id"));
            $jobOrder->update([
                'deleted_by' => request("user_id"),
            ]);
            $jobOrder->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }
}
