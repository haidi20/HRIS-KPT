<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\JobOrderHistory;
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
            ->whereYear("datetime_start", $month->format("Y"))
            ->whereMonth("datetime_start", $month->format("m"))
            ->orderBy("datetime_start", "asc")
            ->get();

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
            $jobOrder->job_id = request("job_id");
            $jobOrder->job_level = request("job_level");
            $jobOrder->job_note = request("job_note");
            $jobOrder->datetime_start = Carbon::parse(request("hour_start"))->format("Y-m-d h:m");
            $jobOrder->datetime_estimation_end = Carbon::parse(request("datetime_estimation_end"));
            $jobOrder->estimation = request("estimation");
            $jobOrder->time_type = request("time_type");
            $jobOrder->category = request("category");
            $jobOrder->note = request("note");
            $jobOrder->save();

            $this->storeJobOrderHistory($jobOrder);
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

    public function storeAction()
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            $message = "diperbaharui";

            $jobOrder = JobOrder::find(request("id"));

            if (request("status") == 'finish') {
                $jobOrder->status = request("status");
                $jobOrder->datetime_end = Carbon::parse(request("date") . ' ' . request("hour"));
            }

            $jobOrder->status = request("status");
            $jobOrder->status_note = request("status_note");
            $jobOrder->save();

            $this->storeJobOrderHistory($jobOrder);

            DB::commit();

            return response()->json([
                'success' => true,
                'request' => request()->all(),
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

    private function storeJobOrderHistory($jobOrder)
    {
        $jobOrderHistory = new JobOrderHistory;
        $jobOrderHistory->job_order_id = $jobOrder->id;
        $jobOrderHistory->project_id = $jobOrder->project_id;
        $jobOrderHistory->job_id = $jobOrder->job_id;
        $jobOrderHistory->job_level = $jobOrder->job_level;
        $jobOrderHistory->job_note = $jobOrder->job_note;
        $jobOrderHistory->status = $jobOrder->status;
        $jobOrderHistory->datetime_start = $jobOrder->datetime_start;
        $jobOrderHistory->datetime_end = $jobOrder->datetime_end;
        $jobOrderHistory->datetime_estimation_end = $jobOrder->datetime_estimation_end;
        $jobOrderHistory->estimation = $jobOrder->estimation;
        $jobOrderHistory->time_type = $jobOrder->time_type;
        $jobOrderHistory->category = $jobOrder->category;
        $jobOrderHistory->note = $jobOrder->note;
        $jobOrderHistory->status_note = $jobOrder->status_note;
        $jobOrderHistory->save();
    }
}
