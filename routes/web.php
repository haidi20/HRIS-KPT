<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ApprovalLevelController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BargeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOrderCategoryController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\JobOrderReportController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\SalaryAdjustmentController;
use App\Http\Controllers\SalaryAdvanceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingHourController;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();

// Guest-only routes
Route::group(['middleware' => 'guest'], function () {
    // Route::get('/', 'Auth\RegisterController@showRegistrationForm');
    Route::get('/', [LoginController::class, "showLoginForm"]);
});

//
Route::group(['middleware' => 'auth'], function () {
    // Route::get('/', 'Auth\RegisterController@showRegistrationForm');
    Route::prefix("dashboard")->name("dashboard.")->group(function () {
        Route::get('', [DashboardController::class, "index"])->name("index");
    });
    Route::prefix("attendance")->name("attendance.")->group(function () {
        Route::get('', [AttendanceController::class, "index"])->name("index");
    });
    Route::prefix("roster")->name("roster.")->group(function () {
        Route::get('', [RosterController::class, "index"])->name("index");
        Route::get('fetch-data', [RosterController::class, "fetchData"])->name("fetchData");
    });
    Route::prefix("salary-advance")->name("salaryAdvance.")->group(function () {
        Route::get('', [SalaryAdvanceController::class, "index"])->name("index");
    });
    Route::prefix("overtime")->name("overtime.")->group(function () {
        Route::get('', [OvertimeController::class, "index"])->name("index");
    });
    Route::prefix("payslip")->name("payslip.")->group(function () {
        Route::get('', [PayslipController::class, "index"])->name("index");
    });
    Route::prefix("payroll")->name("payroll.")->group(function () {
        Route::get('', [PayrollController::class, "index"])->name("index");
    });
    Route::prefix("project")->name("project.")->group(function () {
        Route::get('', [ProjectController::class, "index"])->name("index");
    });
    Route::prefix("job-order")->name("jobOrder.")->group(function () {
        Route::get('', [JobOrderController::class, "index"])->name("index");
    });
    Route::prefix("job-order-report")->name("jobOrderReport.")->group(function () {
        Route::get('', [JobOrderReportController::class, "index"])->name("index");
    });

    Route::prefix("master")->name("master.")->group(function () {
        Route::prefix('company')->name("company.")->group(function () {
            Route::get('', [CompanyController::class, "index"])->name("index");
        });
        Route::prefix('type-employee')->name("typeEmployee.")->group(function () {
            Route::get('', [EmployeeTypeController::class, "index"])->name("index");
        });
        // barge = kapal tongkang
        Route::prefix('barge')->name("barge.")->group(function () {
            Route::get('', [BargeController::class, "index"])->name("index");
        });
        Route::prefix('job')->name("job.")->group(function () {
            Route::get('', [JobController::class, "index"])->name("index");
        });
        Route::prefix('position')->name("position.")->group(function () {
            Route::get('', [PositionController::class, "index"])->name("index");
        });
        Route::prefix('location')->name("location.")->group(function () {
            Route::get('', [LocationController::class, "index"])->name("index");
        });
        Route::prefix('material')->name("material.")->group(function () {
            Route::get('', [MaterialController::class, "index"])->name("index");
        });
        Route::prefix("job-order-category")->name("jobOrderCategory.")->group(function () {
            Route::get('', [JobOrderCategoryController::class, "index"])->name("index");
        });
        Route::prefix("schedule")->name("schedule.")->group(function () {
            Route::get('', [ScheduleController::class, "index"])->name("index");
        });
        Route::prefix('employee')->name("employee.")->group(function () {
            Route::get('', [EmployeeController::class, "index"])->name("index");
            Route::post('store', [EmployeeController::class, "store"])->name("store");
            Route::delete('delete', [EmployeeController::class, "destroy"])->name("delete");
        });
    });
    Route::prefix("setting")->name("setting.")->group(function () {
        Route::prefix('approval-level')->name("approvalLevel.")->group(function () {
            Route::get('', [ApprovalLevelController::class, "index"])->name("index");
        });
        Route::prefix('salary-adjustment')->name("salaryAdjustment.")->group(function () {
            Route::get('', [SalaryAdjustmentController::class, "index"])->name("index");
        });
        Route::prefix('working-hour')->name("workingHour.")->group(function () {
            Route::get('', [WorkingHourController::class, "index"])->name("index");
        });
        Route::prefix('user')->name("user.")->group(function () {
            Route::get('', [UserController::class, "index"])->name("index");
            Route::post('store', [UserController::class, "store"])->name("store");
            Route::delete('delete', [UserController::class, "destroy"])->name("delete");
        });
        Route::prefix('role')->name("role.")->group(function () {
            Route::get('', [RoleController::class, "index"])->name("index");
            Route::post('store', [RoleController::class, "store"])->name("store");
            Route::delete('delete', [RoleController::class, "destroy"])->name("delete");
        });
        Route::prefix('role-permission/{roleId}')->name("rolePermission.")->group(function () {
            Route::get('', [RolePermissionController::class, "index"])->name("index");
            Route::get('show', [RolePermissionController::class, "show"])->name("show");
            Route::post('store', [RolePermissionController::class, "store"])->name("store");
        });
        Route::prefix('feature')->name("feature.")->group(function () {
            Route::get('', [FeatureController::class, "index"])->name("index");
            Route::post('store', [FeatureController::class, "store"])->name("store");
            Route::delete('delete', [FeatureController::class, "destroy"])->name("delete");
        });
        Route::prefix("permission")->name("permission.")->group(function () {
            Route::get('{featureId}', [PermissionController::class, "index"])->name("index");
            Route::post('store', [PermissionController::class, "store"])->name("store");
            Route::delete('delete', [PermissionController::class, "destroy"])->name("delete");
        });
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
