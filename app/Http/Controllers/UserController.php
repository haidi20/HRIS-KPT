<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $userRoleId = auth()->user()->role_id;

        $roles = new Role;
        $users = new User;

        if ($userRoleId != 1) {
            $roles = $roles->where("id", "!=", 1);
            $users = $users->where("id", "!=", 1);
        }

        $roles = $roles->get();
        $users = $users->get();

        return view("pages.setting.user", compact("users", "roles"));
    }

    public function store(Request $request)
    {
        // return request()->all();

        try {
            DB::beginTransaction();

            if (request("id")) {
                $user = User::find(request("id"));

                $message = "diperbaharui";
            } else {
                $user = new User;

                $message = "dikirim";
            }

            if (request("password") != null) {
                $user->password = bcrypt(request("password"));
            }

            $user->name = request("name");
            $user->email = request("email");
            $user->role_id = request("role_id");
            $user->save();

            $role = Role::find(request("role_id"));

            $user->assignRole($role->name);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [],
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

            $user = User::find(request("id"));
            $user->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $user->delete();

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
