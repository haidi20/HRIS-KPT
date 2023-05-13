<?php

namespace App\Http\Controllers;

use App\Models\Departmen;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class DepartmenController extends Controller
{

    public function getLastCode()
    {
        $companyId = request()->input('company_id');

        $lastDepartmen = Departmen::where('company_id', $companyId)
            ->latest('id')
            ->first();

        if ($lastDepartmen) {
            $lastCode = $lastDepartmen->code;
            $newCode = substr($lastCode, 0, 3) . (intval(substr($lastCode, 3)) + 1);
            return response()->json([
                'lastCode' => $newCode,
            ]);
        } else {
            return response()->json([
                'lastCode' => null,
            ]);
        }
    }

    public function index()
    {
        $departmens = Departmen::all();
        $companies = Company::all();

        return view("pages.master.departmen.index", compact("departmens", "companies"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (request("id")) {
                $departmen = Departmen::find(request("id"));
                $departmen->updated_by = Auth::user()->id;

                // Jika sedang edit, tidak perlu mengubah nilai code
                $departmen->code = $departmen->code;

                $message = "diperbaharui";
            } else {
                $departmen = new Departmen;
                $departmen->created_by = Auth::user()->id;

                $company = Company::find(request("company_id"));

                if ($company) {
                    if ($company->id == 1) {
                        $codePrefix = "PT-";
                    } elseif ($company->id == 2) {
                        $codePrefix = "CV-";
                    }
                }

                $lastDepartmen = Departmen::where('company_id', request("company_id"))->latest('id')->first();

                if ($lastDepartmen) {
                    $lastCode = $lastDepartmen->code;
                    // Mendapatkan nomor dari code terakhir
                    $lastCodeNumber = intval(substr($lastCode, -1));
                    // Increment nomor
                    $nextCodeNumber = $lastCodeNumber + 1;
                    // Membentuk code baru dengan nomor yang diincrement
                    $nextCode = substr($lastCode, 0, -1) . $nextCodeNumber;
                    $departmen->code = $nextCode;
                } else {
                    // Jika tabel kosong, set code awal
                    $departmen->code = $codePrefix . '1';
                }

                $message = "dikirim";
            }

            $departmen->name = request("name");
            $departmen->description = request("description");
            $departmen->company_id = request("company_id");
            $departmen->save();

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

            $departmen = Departmen::find(request("id"));
            $departmen->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $departmen->delete();

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
