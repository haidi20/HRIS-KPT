<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index($roleId)
    {
        $nameGroupUser = Role::find($roleId)->name;
        $features = Feature::all();

        return view("pages.setting.role-permission", compact("features", "nameGroupUser", "roleId"));
    }

    public function show()
    {
        $featureId = request("feature_id");
        $roleId = request("role_id");
        // masih bermasalah

        $permissionsByFeature = Permission::where("feature_id", $featureId)->get();
        $permissionsByRole = Role::findById($roleId)->permissions;

        return response()->json([
            "permissionsByRole" => $permissionsByRole,
            "permissionsByFeature" => $permissionsByFeature,
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $roleId = request("role_id");
            $permissionsByRoleId = [];

            if ($request->permissions_by_role != null) {
                foreach ($request->permissions_by_role as $index => $permission) {
                    array_push($permissionsByRoleId, $permission["id"]);
                }
            }

            foreach ($request->permissions_by_feature as $index => $permission) {
                $role = Role::findById($roleId);

                if (in_array($permission["id"], $permissionsByRoleId)) {
                    $role->givePermissionTo($permission["name"]);
                } else {
                    $role->revokePermissionTo($permission["name"]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil diperbaharui',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Maaf, gagal kirim data'], 500);
        }
    }
}
