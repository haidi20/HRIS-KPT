<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();

        return view("pages.master.job.index", compact("jobs"));
    }

    public function fetchData()
    {
        $jobs = Job::orderBy("name", "asc")->get();

        return response()->json([
            "jobs" => $jobs,
        ]);
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $job = Job::find(request("id"));
                $job->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $job = new Job;
                $job->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $job->code = request("code");
            $job->name = request("name");
            $job->description = request("description");
            $job->save();

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

            $job = Job::find(request("id"));
            $job->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $job->delete();

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
