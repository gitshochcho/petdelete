<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\DoctorController;
use Modules\Admin\Http\Controllers\PetCategoryController;
use Modules\Admin\Http\Controllers\PetSubcategoryController;
use Modules\Admin\Http\Controllers\PetBreedController;
use Modules\Admin\Http\Controllers\PetController;
use Modules\Admin\Http\Controllers\ServiceController;
use Modules\Admin\Http\Controllers\ProfileController;

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

Route::group(['middleware' => ['auth:admin']], function () {
    Route::resource('admin', AdminController::class)->names('admin');

    // Profile management routes
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('admin.profile.change-password');
    Route::put('profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update-password');

    // Pet management routes
    Route::resource('pet-categories', PetCategoryController::class)->names('admin.pet-categories');
    Route::resource('pet-subcategories', PetSubcategoryController::class)->names('admin.pet-subcategories');
    Route::resource('pet-breeds', PetBreedController::class)->names('admin.pet-breeds');
    Route::resource('pets', PetController::class)->names('admin.pets');
    Route::get('pets/{pet}/device', [PetController::class, 'device'])->name('admin.pets.device');

    // Service management routes
    Route::resource('services', ServiceController::class)->names('admin.services');

    // Appointment management routes
    Route::post('appointments/update-status', [AdminController::class, 'updateAppointmentStatus'])->name('admin.appointments.updateStatus');
    Route::delete('appointments/delete', [AdminController::class, 'deleteAppointment'])->name('admin.appointments.delete');
    Route::get('appointments/{id}/details', [AdminController::class, 'getAppointmentDetails'])->name('admin.appointments.details');

    Route::get('doctors', [DoctorController::class, 'index'])->name('admin.doctors.index');
    Route::post('doctors/{id}/update-status', [DoctorController::class, 'updateStatus'])->name('admin.doctors.update-status');
});
