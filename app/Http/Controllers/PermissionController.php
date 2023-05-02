<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function feature()
    {
        $features = Feature::all();

        return view("pages.setting.feature", compact("features"));
    }

    public function permission($featureId)
    {
        $permissions = Permission::where("feature_id", $featureId)->get();

        return view("pages.setting.permission", compact("permissions"));
    }
}
