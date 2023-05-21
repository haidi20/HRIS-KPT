<?php

namespace App\Http\Controllers;

use App\Models\Barge;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $companies = Company::all();
        $barges = Barge::all();

        return view("pages.master.customer.index", compact("customers", "companies", "barges"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $customer = Customer::find(request("id"));
                $customer->updated_by = Auth::user()->id;

                $message = "diperbaharui";
            } else {
                $customer = new Customer;
                $customer->created_by = Auth::user()->id;

                $message = "ditambahkan";
            }

            $customer->name = request("name");
            $customer->company_id = request("company_id");
            $customer->barge_id = request("barge_id");
            $customer->save();

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

            $customer = Customer::find(request("id"));
            $customer->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $customer->delete();

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
