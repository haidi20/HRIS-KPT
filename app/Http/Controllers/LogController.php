<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function store($message, $location)
    {
        // return request()->all();

        if (request("user_id") != null) {
            $userId = request("user_id");
        } else {
            $userId = Auth::user()->id;
        }

        try {
            DB::beginTransaction();

            $log = new Log;

            $log->user_id = $userId;
            $log->message = limitString($message, 400);
            $log->location = $location;
            $log->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e);

            return false;
        }
    }
}
