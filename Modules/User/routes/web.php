<?php

use App\Models\Appointment;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\PetController;
use Modules\User\Http\Controllers\UserController;

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

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::resource('/', UserController::class)->names('user');
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('profile/update', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::resource('pets', PetController::class)->names('user.pets');
    Route::get('appointments', [UserController::class, 'userAppointments'])->name('user.appointments.index');
    Route::get('appointments/{appointment}', [UserController::class, 'showAppointment'])->name('user.appointments.show');

    Route::get('pets/{pet}/device', [PetController::class, 'device'])->name('user.pets.device');
});
