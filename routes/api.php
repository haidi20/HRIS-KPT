<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\RosterStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->name("api.")->group(function () {
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('fetch-data', [AttendanceController::class, "fetchData"])->name('fetchData');
        Route::post('store', [AttendanceController::class, "store"])->name('store');
    });
    Route::prefix('roster')->name('roster.')->group(function () {
        Route::get('fetch-data', [RosterController::class, "fetchData"])->name('fetchData');
        Route::get('fetch-total', [RosterController::class, "fetchTotal"])->name('fetchTotal');
        Route::post('store', [RosterController::class, "store"])->name('store');
    });
    Route::prefix('roster-status')->name('rosterStatus.')->group(function () {
        Route::get('fetch-data', [RosterStatusController::class, "fetchData"])->name('fetchData');
        Route::post('store', [RosterStatusController::class, "store"])->name('store');
        Route::post('delete', [RosterStatusController::class, "destroy"])->name('delete');
    });
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('fetch-bpjs', [PayrollController::class, "fetchBpjs"])->name('fetchBpjs');
        Route::get('fetch-salary', [PayrollController::class, "fetchSalary"])->name('fetchSalary');
        Route::get('fetch-information', [PayrollController::class, "fetchInformation"])->name('fetchInformation');
    });
});
