<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        return view("pages.setting.feature", compact("features"));
    }

    public function task($featureId)
    {
        $permissions = Permission::where("task_id", $featureId)->get();

        return view("pages.setting.permission", compact("permissions"));
    }
}
