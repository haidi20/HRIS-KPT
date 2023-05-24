<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $userRoleId = auth()->user()->role_id;

        $roles = new Role;

        if ($userRoleId != 1) {
            $roles = $roles->where("id", "!=", 1)
                ->where("id", "!=", 2);
        }

        $roles = $roles->orderBy('created_at', 'desc')->get();

        return view("pages.setting.role", compact("roles"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            // Role::updateOrCreate(
            //     ["id" => $request->id],
            //     [
            //         "name" => $request->name,
            //         "guard_name" => "web",
            //     ]
            // );

            if (request("id")) {
                $role = Role::find(request("id"));

                $message = "diperbaharui";
            } else {
                $role = new Role;

                $message = "ditambahkan";
            }

            $role->name = request("name");
            $role->guard_name = "web";
            $role->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil Kirim Data'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Maaf, gagal kirim data'], 500);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $role = Role::find(request("id"));
            $role->update([
                'deleted_by' => request("user_id"),
            ]);
            $role->delete();

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
