<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\JobOrderHasStatus;
use App\Models\JobOrderHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


class JobOrderController extends Controller
{
    private $nameModel = "App\Models\JobOrder";

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

        $jobOrders = JobOrder::with(["jobOrderHasEmployees", "jobOrderAssessments"])
            ->whereYear("datetime_start", $month->format("Y"))
            ->whereMonth("datetime_start", $month->format("m"))
            ->orderBy("datetime_start", "desc")
            ->get();

        return response()->json([
            "jobOrders" => $jobOrders,
        ]);
    }

    public function store()
    {
        // return request()->all();
        $jobStatusController = new JobStatusController;

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

            $date = Carbon::now();
            $date->setTimeFromTimeString(request("hour_start"));
            // $date = Carbon::createFromFormat("h:m", request("hour_start"))->format("Y-m-d h:m");

            $jobOrder->project_id = request("project_id");
            $jobOrder->job_id = request("job_id");
            $jobOrder->job_level = request("job_level");
            $jobOrder->job_note = request("job_note");
            //datetime_end inputnya di storeAction
            $jobOrder->datetime_start = $date;
            $jobOrder->datetime_estimation_end = Carbon::parse(request("datetime_estimation_end"));
            $jobOrder->estimation = request("estimation");
            $jobOrder->time_type = request("time_type");
            $jobOrder->category = request("category");
            $jobOrder->note = request("note");
            $jobOrder->save();

            // tambah data jobOrderHasStatus hanya ketika data baru
            if (request("id") == null) {
                $jobStatusController->storeJobStatusHasParent($jobOrder, $date, $this->nameModel);
            }

            $this->storeJobOrderHistory($jobOrder);
            // $this->storeOrdinarySeamans($jobOrder);

            DB::commit();

            return response()->json([
                'success' => true,
                'requests' => request()->all(),
                'date' => $date,
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
        $jobStatusController = new JobStatusController;

        try {
            DB::beginTransaction();

            $date = Carbon::parse(request("date") . ' ' . request("hour"))->format("Y-m-d H:i");
            $message = "diperbaharui";

            $jobOrder = JobOrder::find(request("id"));

            if (request("status") == 'finish') {
                $jobOrder->status = request("status");
                $jobOrder->datetime_end = $date;
            }

            $jobOrder->status = request("status");
            $jobOrder->status_note = request("status_note");
            $jobOrder->save();

            $jobStatusController->storeJobStatusHasParent($jobOrder, $date, $this->nameModel);
            $this->storeJobOrderHistory($jobOrder);

            DB::commit();

            return response()->json([
                'success' => true,
                'request' => request()->all(),
                'jobOrder' => $jobOrder,
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
            $this->storeJobOrderHistory($jobOrder, true);
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

    private function storeJobOrderHistory($jobOrder, $isDelete = false)
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
        $jobOrderHistory->deleted_by = $jobOrder->deleted_by;

        if ($isDelete) {
            $jobOrderHistory->deleted_at = Carbon::now();
        }

        $jobOrderHistory->save();
    }
}
