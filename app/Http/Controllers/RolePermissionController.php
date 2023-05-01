<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $roleId = request("role_id");

        $permissions = Auth::user()->getAllPermissions();

        // $role = Role::findById($roleId)
        //     ->load('permissions');

        return response()->json([
            "role_id" => $roleId,
            // "role" => $role,
            "permissions" => $permissions
        ]);
    }
}
