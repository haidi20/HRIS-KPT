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

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);
        } else {
            $jobStatusHasParent = new JobStatusHasParent;
            $jobStatusHasParent->parent_id = $parent->id;
            $jobStatusHasParent->parent_model = $nameModel;
            $jobStatusHasParent->status = $parent->status;
            $jobStatusHasParent->datetime_start = $date;
            $jobStatusHasParent->note_start = $parentNote;
            $jobStatusHasParent->save();

            $this->storeJobStatusHasParentHistory($jobStatusHasParent, false);
        }
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
}
