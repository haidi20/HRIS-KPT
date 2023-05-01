<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SalaryAdjustmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingHourController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('modules/dashboard/index');
});

Route::prefix("setting")->name("setting.")->group(function () {
    Route::prefix('salary-adjusment')->name("salaryAdjustment.")->group(function () {
        Route::get('', [SalaryAdjustmentController::class, "index"])->name("index");
    });
    Route::prefix('working-hour')->name("workingHour.")->group(function () {
        Route::get('', [WorkingHourController::class, "index"])->name("index");
    });
    Route::prefix('user')->name("user.")->group(function () {
        Route::get('', [UserController::class, "index"])->name("index");
    });
    Route::prefix('permission')->name("permission.")->group(function () {
        Route::get('', [PermissionController::class, "index"])->name("index");
    });
});
