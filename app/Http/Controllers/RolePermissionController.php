<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index($roleId)
    {
        $nameGroupUser = Role::find($roleId)->name;
        $features = Feature::all();

        return view("pages.setting.role-permission", compact("features", "nameGroupUser"));
    }
}
