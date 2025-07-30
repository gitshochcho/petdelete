<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [App\Http\Controllers\HomeController::class, 'login'])->name('home');

Route::get('login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::post('validate/login', [App\Http\Controllers\HomeController::class, 'validateLogin'])->name('loginCheck');
Route::get('/register', [App\Http\Controllers\HomeController::class, 'registration'])->name('registration');
Route::post('store/register', [App\Http\Controllers\HomeController::class, 'storRegistration'])->name('storRegistration');
Route::get('forget/password', [App\Http\Controllers\HomeController::class, 'loadForgetMyPass'])->name('forgetMyPass');
Route::post('user/check', [App\Http\Controllers\HomeController::class, 'searchUser'])->name('searchUser');
Route::match(['get', 'post'], 'user/load/otp', [HomeController::class, 'userOtpLoad'])->name('userOtpLoad');
Route::post('validate/user/otp', [HomeController::class, 'validateUserOtp'])->name('validateUserOtp');
Route::post('update/user/pass', [HomeController::class, 'updateUserPassword'])->name('updateUserPassword');

// socialite

Route::get('google/oauth/load', [App\Http\Controllers\HomeController::class, 'googleOauthLoad'])->name('googleOauthLoad');
Route::get('google/auth/callback', [App\Http\Controllers\HomeController::class, 'googleOauthCallBack'])->name('googleOauthCallBack');




Route::prefix('user')->group(function () {

    Route::middleware(['auth'])->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('user.dashboard');
            Route::get('logout', 'logout')->name('user.logout');
        //     Route::post('store', 'store');
        //     Route::post('update/{survey:uuid}', 'update');
        //     Route::get('show/{survey:uuid}', 'show');
        //     Route::get('cheak/status/{survey:uuid}', 'cheakStatus');
        });


    });

    // Route::get('user/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('user.dashboard');
    Route::prefix('surveys')->group(function () {

        // Route::controller(HomeController::class)->group(function () {
        //     Route::get('list', 'index');
        //     Route::post('store', 'store');
        //     Route::post('update/{survey:uuid}', 'update');
        //     Route::get('show/{survey:uuid}', 'show');
        //     Route::get('cheak/status/{survey:uuid}', 'cheakStatus');
        // });
    });



});
