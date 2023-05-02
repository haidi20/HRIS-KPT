<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SalaryAdjustmentController;
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

Route::prefix("dashboard")->name("dashboard.")->group(function () {
    Route::get('', [DashboardController::class, "index"])->name("index");
});

Route::prefix("master")->name("master.")->group(function () {
    Route::prefix('position')->name("position.")->group(function () {
        Route::get('', [PositionController::class, "index"])->name("index");
    });
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
    Route::prefix('role')->name("role.")->group(function () {
        Route::get('', [RoleController::class, "index"])->name("index");
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
        Route::get('permission/{featureId}', [PermissionController::class, "index"])->name("index");
        Route::post('store', [PermissionController::class, "store"])->name("store");
        Route::delete('delete', [PermissionController::class, "destroy"])->name("delete");
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
