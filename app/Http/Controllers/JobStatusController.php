<?php

namespace App\Http\Controllers;

use App\Models\ImageHasParent;
use App\Models\JobStatusHasParent;
use App\Models\JobStatusHasParentHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class JobStatusController extends Controller
{
    public function fetchDataBaseJobOrder()
    {
        $jobOrderId = request("job_order_id");
        $jobStatusHasParents = JobStatusHasParent::with("images")
            ->where([
                "parent_id" => $jobOrderId,
                "parent_model" => "App\Models\JobOrder"
            ])->get();

        return response()->json([
            "jobStatusHasParents" => $jobStatusHasParents,
            "requests" => request()->all(),
        ]);
    }

    public function fetchDataOvertimeBaseUser()
    {
        $overtimes = [];
        $month = Carbon::parse(request("month"));
        $employeeId = User::find(request("user_id"))->employee_id;

        if ($employeeId != null) {
            $overtimes = JobStatusHasParent::where("employee_id", $employeeId)
                ->where("status", "overtime");

            if (request("is_date_filter") == "true") {
                $overtimes = $overtimes->whereDate("datetime_start", request("date"));
            } else {
                $overtimes = $overtimes->whereYear("datetime_start", $month->format("Y"))
                    ->whereMonth("datetime_start", $month->format("m"));
            }

            $overtimes = $overtimes->orderBy("datetime_start", "desc")->get();
        }

        return response()->json([
            "overtimes" => $overtimes,
            "requests" => request()->all(),
        ]);
    }

    public function fetchDataOvertimeBaseEmployee()
    {
        $overtimes = [];
        $month = Carbon::parse(request("month"));
        $employeeId = User::find(request("user_id"))->employee_id;

        if ($employeeId != null) {
            $overtimes = JobStatusHasParent::where("employee_id", "!=", $employeeId)
                ->where("created_by", request("user_id"))
                ->where("status", "overtime");

            if (request("is_date_filter") == "true") {
                $overtimes = $overtimes->whereDate("datetime_start", request("date"));
            } else {
                $overtimes = $overtimes->whereYear("datetime_start", $month->format("Y"))
                    ->whereMonth("datetime_start", $month->format("m"));
            }

            $overtimes = $overtimes->orderBy("datetime_start", "desc")->get();
        }

        return response()->json([
            "overtimes" => $overtimes,
            "requests" => request()->all(),
        ]);
    }

    public function downloadImage()
    {
        try {
            $imageHasParent = ImageHasParent::find(request("image_has_parent_id"));
            $path = $imageHasParent->path_name;
            $name = $imageHasParent->name;

            return response()->download(
                storage_path($path),
                $name
            );
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => 'Maaf, gagal download gambar'
            ], 500);
        }
    }

    public function storeJobStatusHasParent($parent, $statusLast = null, $date, $nameModel)
    {
        // $statusLast = request("status_last");
        $parentNote = null;
        if (isset($parent["status_note"])) {
            $parentNote = $parent["status_note"];
        }

        if ($statusLast != null) {

            $jobStatusHasParent = JobStatusHasParent::where([
                "status" => $statusLast,
                "parent_id" => $parent->id,
                "parent_model" => $nameModel,
            ])->orderBy("created_at", "desc")->first();

            // if ($jobStatusHasParent) {
            $jobStatusHasParent->update([
                "note_end" => $parentNote,
                "datetime_end" => $date,
            ]);

            $getValidationDatetime = $this->getValidationDatetime($jobStatusHasParent->datetime_start, $jobStatusHasParent->datetime_end);

            if ($getValidationDatetime) {
                return (object) [
                    'error' => true,
                    'data' => [],
                    'message' => "Maaf, waktu selesai tidak boleh kurang dari waktu mulai",
                ];
            } else {
                $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);
            }

            // }
        } else {
            $jobStatusHasParent = new JobStatusHasParent;
            $jobStatusHasParent->parent_id = $parent->id;
            $jobStatusHasParent->parent_model = $nameModel;
            $jobStatusHasParent->job_order_id = $parent->id;
            $jobStatusHasParent->status = $parent->status;
            $jobStatusHasParent->datetime_start = $date;
            $jobStatusHasParent->note_start = $parentNote;

            if ($nameModel == "App\Models\JobOrderHasEmployee") {
                $jobStatusHasParent->job_order_id = $parent->job_order_id;
                $jobStatusHasParent->employee_id = $parent->employee_id;
            }

            $jobStatusHasParent->save();

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);
        }

        return (object) [
            'error' => false,
            'data' => $jobStatusHasParent,
        ];
    }

    public function storeOvertime()
    {
        $user = User::find(request("user_id"));
        $datetimeStart = Carbon::parse(request("date_start") . request("hour_start"));
        $datetimeEnd = Carbon::parse(request("date_end") . request("hour_end"));

        $getStoreValidation = $this->storeOvertimeValidation($user);

        if ($getStoreValidation) {
            return response()->json([
                'success' => false,
                'message' => $this->storeOvertimeValidation($user, "result"),
            ], 400);
        }

        try {
            DB::beginTransaction();

            if (request("id")) {
                $jobStatusHasParent = JobStatusHasParent::find(request("id"));

                $message = "Diperbaharui";
            } else {
                $jobStatusHasParent = new JobStatusHasParent;

                $message = "Ditambahkan";
            }

            $userEmployeeId = $user ? $user->employee_id : null;

            $employeeId = request("employee_id", $userEmployeeId);

            $jobStatusHasParent->employee_id = $employeeId;
            $jobStatusHasParent->status = "overtime";
            $jobStatusHasParent->datetime_start = $datetimeStart;
            $jobStatusHasParent->datetime_end = $datetimeEnd;
            $jobStatusHasParent->note_start = request("note");
            $jobStatusHasParent->save();

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);

            DB::commit();
            return response()->json([
                'success' => true,
                'request' => request()->all(),
                'message' => "Berhasil {$message}",
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => "Maaf, Gagal {$message}",
            ], 500);
        }
    }

    public function storeOvertimeRevision()
    {
        $datetimeStart = Carbon::parse(request("datetime_start"));
        $datetimeEnd = Carbon::parse(request("datetime_end"));

        if ($datetimeStart->greaterThan($datetimeEnd)) {
            return response()->json([
                'success' => false,
                'message' => "Maaf, Waktu mulai lembur lebih besar dari waktu selesai lembur",
            ], 500);
        }

        try {
            DB::beginTransaction();

            $jobStatusHasParent = JobStatusHasParent::find(request("id"));
            $jobStatusHasParent->datetime_start = request("datetime_start");
            $jobStatusHasParent->datetime_end = request("datetime_end");
            $jobStatusHasParent->save();

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Perbaharui Data'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => 'Maaf, gagal Perbaharui data'
            ], 500);
        }
    }

    public function updateJobStatusHasParent($parent, $nameModel)
    {
        $jobStatusHasParent = JobStatusHasParent::where([
            "parent_id" => $parent->id,
            "parent_model" => $nameModel,
            "status" => $parent->status,
            "datetime_end" => null
        ])->orderBy("created_at", "desc")->first();

        $jobStatusHasParent->datetime_start = $parent->datetime_start;
        $jobStatusHasParent->note_start = $parent->note_start;
        $jobStatusHasParent->save();

        return (object) [
            'error' => false,
            'data' => $jobStatusHasParent,
        ];
    }

    public function destroyJobStatusHasParent()
    {
        try {
            DB::beginTransaction();

            $jobStatusHasParent = JobStatusHasParent::find(request("id"));
            $jobStatusHasParent->update([
                'deleted_by' => request("user_id"),
            ]);
            $jobStatusHasParent->delete();

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, true);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            $routeAction = Route::currentRouteAction();
            $log = new LogController;
            $log->store($e->getMessage(), $routeAction);


            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus',
            ], 500);
        }
    }

    public function destroyJobStatusHasParentBaseJobOrder($jobOrder, $nameModel)
    {
        $jobStatusHasParent = JobStatusHasParent::where([
            "parent_id" => $jobOrder->id,
            "parent_model" => $nameModel,
        ]);
        $jobStatusHasParent->update([
            'deleted_by' => request("user_id"),
        ]);

        foreach ($jobStatusHasParent->get() as $index => $item) {
            $getData = JobStatusHasParent::find($item->id);

            $this->storeJobStatusHasParentHistory($getData, true);
        }

        $jobStatusHasParent->delete();
    }

    private function storeJobStatusHasParentHistory($jobStatusHasParent, $isDelete = false)
    {
        $jobStatusHasParentHistory = new JobStatusHasParentHistory;
        $jobStatusHasParentHistory->job_status_has_parent_id = $jobStatusHasParent->id;
        $jobStatusHasParentHistory->parent_id = $jobStatusHasParent->parent_id;
        $jobStatusHasParentHistory->parent_model = $jobStatusHasParent->parent_model;
        $jobStatusHasParentHistory->status = $jobStatusHasParent->status;
        $jobStatusHasParentHistory->datetime_start = $jobStatusHasParent->datetime_start;
        $jobStatusHasParentHistory->datetime_end = $jobStatusHasParent->datetime_end;
        $jobStatusHasParentHistory->note_start = $jobStatusHasParent->note_start;
        $jobStatusHasParentHistory->note_end = $jobStatusHasParent->note_end;
        $jobStatusHasParentHistory->deleted_by = $jobStatusHasParent->deleted_by;

        if ($isDelete) {
            $jobStatusHasParentHistory->deleted_at = Carbon::now();
        }

        $jobStatusHasParentHistory->save();
    }

    private function getValidationDatetime($start, $end)
    {
        if ($end < $start) {
            return true;
        }

        return false;
    }

    private function storeOvertimeValidation($user, $type = null)
    {
        $isError = false;
        $message = null;

        $datetimeStart = Carbon::parse(request("date_start") . request("hour_start"));
        $datetimeEnd = Carbon::parse(request("date_end") . request("hour_end"));

        if (request("user_id") == null) {
            $isError = true;
            $message = "Maaf, anda harus login ulang";
        } else if ($datetimeStart->greaterThan($datetimeEnd)) {
            $isError = true;
            $message = "Maaf, Waktu mulai lembur lebih besar dari waktu selesai lembur";
        } else if ($user && $user->employee_id == null && request("employee_id") == null) {
            $isError = true;
            $message = "Maaf, akun anda belum di ketahui data karyawan";
        } else if (request("hour_start") == null || request("hour_end") == null) {
            $isError = true;
            $message = "Maaf, jam tidak boleh kosong";
        }

        if ($type == "result") {
            return $message;
        }

        return $isError;
    }
}
