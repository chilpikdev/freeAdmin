<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\DeveloperContoller;
use App\Http\Controllers\Users\BrokerSharedAccessController;
use App\Http\Controllers\Users\BrokerController;
use App\Http\Controllers\Users\SalesManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// clear all
Route::get('clear', function() {
    Artisan::call("optimize:clear");
    return "все ок";
});

Route::get('admin', function() {
    return redirect(route('admin.login'));
});

Route::get('/', [PageController::class, 'homePage'])->name('homePage'); // home page

/**
 * for unauthenticated
 */
Route::middleware('guest:web')->prefix('user')->group(function() {
    // auth
});

/**
 * for authenticated
 */
Route::middleware('auth:web')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['role:user'], 'prefix' => 'user'], function () {
        // routes for users
    });

    Route::group(['middleware' => ['role:moderator'], 'prefix' => 'moderator'], function () {
        // routes for moderators
    });
});


