<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class CompanyController extends Controller
{
    public function index()
    {
        $companys = Company::all();

        return view("pages.master.company.index", compact("companys"));
    }

    public function fetchData()
    {
        $companies = Company::orderBy("name", "asc")->get();

        return response()->json([
            "companies" => $companies,
        ]);
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $company = Company::find(request("id"));
                $company->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $company = new Company;
                $company->created_by = Auth::user()->id;

                $message = "dikirim";
            }

            $company->name = request("name");
            $company->description = request("description");
            $company->save();

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

            $company = Company::find(request("id"));
            $company->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $company->delete();

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
