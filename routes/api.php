<?php

use App\Http\Controllers\ApprovalAgreementController;
use App\Http\Controllers\ApprovalLevelController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BargeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\JobStatusController;
use App\Http\Controllers\OrdinarySeamanController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\RosterStatusController;
use App\Http\Controllers\SalaryAdjustmentController;
use App\Http\Controllers\SalaryAdvanceController;
use App\Http\Controllers\SalaryAdvanceReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\VacationReportController;
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
    // START LAPORAN
    Route::prefix('report')->name('report.')->group(function () {
        Route::prefix('vacation')->name('vacation.')->group(function () {
            Route::get('fetch-data', [VacationReportController::class, "fetchData"])->name('fetchData');
        });
        Route::prefix('salary-advance')->name('salaryAdvance.')->group(function () {
            Route::get('fetch-data', [SalaryAdvanceReportController::class, "fetchData"])->name('fetchData');
        });
    });
    // END LAPORAN

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
        Route::get('store-finger-spot', [AttendanceController::class, "storeFingerSpot"])->name('storeFingerSpot');
        Route::get('store-has-employee', [AttendanceController::class, "storeHasEmployee"])->name('storeHasEmployee');
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
        Route::post('store-approval', [SalaryAdvanceController::class, "storeApproval"])->name('storeApproval');
        Route::post('delete', [SalaryAdvanceController::class, "destroy"])->name('delete');
    });
    Route::prefix('project')->name('project.')->group(function () {
        Route::get('fetch-data', [ProjectController::class, "fetchData"])->name('fetchData');
        Route::get('fetch-data-base-date-end', [ProjectController::class, "fetchDataBaseDateEnd"])->name('fetchDataBaseDateEnd');
        Route::post('store', [ProjectController::class, "store"])->name('store');
        Route::post('delete', [ProjectController::class, "destroy"])->name('delete');
    });
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('fetch-permission', [UserController::class, "fetchPermission"])->name('fetchPermission');
    });
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('fetch-data', [EmployeeController::class, "fetchData"])->name('fetchData');
        Route::get('fetch-option', [EmployeeController::class, "fetchOption"])->name('fetchOption');
        Route::get('fetch-foreman', [EmployeeController::class, "fetchForeman"])->name('fetchForeman');
    });
    Route::prefix('barge')->name('barge.')->group(function () {
        Route::get('fetch-data', [BargeController::class, "fetchData"])->name('fetchData');
    });
    Route::prefix('job')->name('job.')->group(function () {
        Route::get('fetch-data', [JobController::class, "fetchData"])->name('fetchData');
    });
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('fetch-data', [CompanyController::class, "fetchData"])->name('fetchData');
    });
    Route::prefix('contractor')->name('contractor.')->group(function () {
        Route::get('fetch-data', [ContractorController::class, "fetchData"])->name('fetchData');
        Route::post('store', [ContractorController::class, "store"])->name('store');
        Route::post('delete', [ContractorController::class, "destroy"])->name('delete');
    });
    Route::prefix('ordinary-seaman')->name('ordinarySeaman.')->group(function () {
        Route::get('fetch-data', [OrdinarySeamanController::class, "fetchData"])->name('fetchData');
        Route::post('store', [OrdinarySeamanController::class, "store"])->name('store');
        Route::post('delete', [OrdinarySeamanController::class, "destroy"])->name('delete');
    });
    Route::prefix('job-order')->name('jobOrder.')->group(function () {
        Route::get('fetch-data', [JobOrderController::class, "fetchData"])->name('fetchData');
        Route::post('store', [JobOrderController::class, "store"])->name('store');
        Route::post('store-action', [JobOrderController::class, "storeAction"])->name('storeAction');
        Route::post('store-action-assessment', [JobOrderController::class, "storeActionAssessment"])->name('storeActionAssessment');
        Route::post('store-action-has-employee', [JobOrderController::class, "storeActionHasEmployee"])->name('storeActionHasEmployee');
        Route::post('store-action-job-order-has-employee', [JobOrderController::class, "storeActionJobOrderHasEmployee"])->name('storeActionJobOrderHasEmployee');
        Route::post('delete', [JobOrderController::class, "destroy"])->name('delete');
    });
    // Route::prefix('job-status')->name('jobStatus.')->group(function () {
    // });
    Route::prefix('salary-adjustment')->name('salaryAdjustment.')->group(function () {
        Route::get('fetch-data', [SalaryAdjustmentController::class, "fetchData"])->name('fetchData');
        Route::post('store', [SalaryAdjustmentController::class, "store"])->name('store');
    });
});
