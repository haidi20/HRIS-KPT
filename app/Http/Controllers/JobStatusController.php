<?php

namespace App\Http\Controllers;

use App\Models\JobStatusHasParent;
use App\Models\JobStatusHasParentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobStatusController extends Controller
{
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


            $jobStatusHasParent->update([
                "note_end" => $parentNote,
                "datetime_end" => $date,
            ]);

            $getValidationDatetime = $this->getValidationDatetime($jobStatusHasParent->datetime_start, $jobStatusHasParent->datetime_end);

            if ($getValidationDatetime) {
                return (object) [
                    'error' => true,
                    'message' => "Maaf, waktu selesai tidak boleh kurang dari waktu mulai",
                ];
            }

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);
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
}
