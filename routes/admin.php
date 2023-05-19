<?php

use App\Http\Controllers\Admin\Users\AdminController;
use App\Http\Controllers\Admin\Users\ModeratorController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware('guest:admin')->group(function() {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login_process', [AuthController::class, 'login'])->name('login_process');
});

Route::middleware('auth:admin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('delete-file', [AjaxController::class, 'deleteFile']); // is ajax requestw

    Route::group(['middleware' => ['can:dashboard']], function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    });

    Route::group(['middleware' => ['can:manage-users'], 'prefix' => 'manage'], function () {
        Route::group(['prefix' => 'user'], function() {
            Route::resource('admins', AdminController::class);
            Route::resource('moderators', ModeratorController::class);
            Route::resource('users', UserController::class);
        });
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    Route::group(['middleware' => ['can:settings']], function () {
        Route::get('settings', [SettingController::class, 'index'])->name("settings.index");
        Route::get('settings/{id}/edit', [SettingController::class, 'edit'])->name("settings.edit");
        Route::put('settings/{id}', [SettingController::class, 'update'])->name("settings.update");
    });
});

// Route::group(['middleware' => ['role:super-admin|writer']], function () {
//     //
// });

// Route::group(['middleware' => ['can:publish articles']], function () {
//     //
// });

// Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
//     //
// });

