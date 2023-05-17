<?php

use App\Http\Controllers\ApprovalAgreementController;
use App\Http\Controllers\ApprovalLevelController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\RosterStatusController;
use App\Http\Controllers\SalaryAdvanceController;
use App\Http\Controllers\VacationController;
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
    Route::prefix("approval-level")->name("approvalLevel.")->group(function () {
        Route::get("edit", [ApprovalLevelController::class, "edit"])->name("edit");
        Route::get("select-autorizeds", [ApprovalLevelController::class, "selectAuthorizeds"])->name("selectAuthorizeds");
        Route::get("select-approval-level", [ApprovalLevelController::class, "selectApprovalLevel"])->name("selectApprovalLevel");

        Route::post("delete", [ApprovalLevelController::class, "destroy"])->name("delete");
    });
    Route::prefix("approval-agreement")->name("approvalAgreement.")->group(function () {
        Route::get("approve", [ApprovalAgreementController::class, "approve"])->name("approve");
        Route::get("history", [ApprovalAgreementController::class, "history"])->name("history");
        Route::get("all-hiistory", [ApprovalAgreementController::class, "allHistory"])->name("allHistory");
    });
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('fetch-data-main', [AttendanceController::class, "fetchDataMain"])->name('fetchDataMain');
        Route::get('fetch-data-detail', [AttendanceController::class, "fetchDataDetail"])->name('fetchDataDetail');
        Route::post('store', [AttendanceController::class, "store"])->name('store');
    });
    Route::prefix('roster')->name('roster.')->group(function () {
        Route::get('fetch-data', [RosterController::class, "fetchData"])->name('fetchData');
        Route::get('fetch-total', [RosterController::class, "fetchTotal"])->name('fetchTotal');
        Route::post('store', [RosterController::class, "store"])->name('store');
        Route::post('store-change-status', [RosterController::class, "storeChangeStatus"])->name('storeChangeStatus');
    });
    Route::prefix('roster-status')->name('rosterStatus.')->group(function () {
        Route::get('fetch-data', [RosterStatusController::class, "fetchData"])->name('fetchData');
        Route::post('store', [RosterStatusController::class, "store"])->name('store');
        Route::post('delete', [RosterStatusController::class, "destroy"])->name('delete');
    });
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('fetch-bpjs', [PayrollController::class, "fetchBpjs"])->name('fetchBpjs');
        Route::get('fetch-pph21', [PayrollController::class, "fetchPph21"])->name('fetchPph21');
        Route::get('fetch-salary', [PayrollController::class, "fetchSalary"])->name('fetchSalary');
        Route::get('fetch-information', [PayrollController::class, "fetchInformation"])->name('fetchInformation');
    });
    Route::prefix('position')->name('position.')->group(function () {
        Route::get('fetch-data', [PositionController::class, "fetchData"])->name('fetchData');
    });
    Route::prefix('vacation')->name('vacation.')->group(function () {
        Route::get('fetch-data', [VacationController::class, "fetchData"])->name('fetchData');
        Route::post('store', [VacationController::class, "store"])->name('store');
        Route::post('delete', [VacationController::class, "destroy"])->name('delete');
    });
    Route::prefix('salary-advance')->name('salaryAdvance.')->group(function () {
        Route::get('fetch-data', [SalaryAdvanceController::class, "fetchData"])->name('fetchData');
        Route::post('store', [SalaryAdvanceController::class, "store"])->name('store');
        Route::post('delete', [SalaryAdvanceController::class, "destroy"])->name('delete');
    });
    Route::prefix('project')->name('project.')->group(function () {
        Route::get('fetch-data', [ProjectController::class, "fetchData"])->name('fetchData');
        Route::post('store', [ProjectController::class, "store"])->name('store');
        Route::post('delete', [ProjectController::class, "destroy"])->name('delete');
    });
});
