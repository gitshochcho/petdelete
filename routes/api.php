<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Appointment API Routes


// Create new appointment
Route::post('appointment/store', [HomeController::class, 'createAppointment']);

// Get available doctors
Route::get('doctors', [HomeController::class, 'getAvailableDoctors']);

// Get user's pets
Route::get('user/pets', [HomeController::class, 'getUserPets']);
Route::get('user/detail', [HomeController::class, 'getNormalUser']);

Route::get('get/doctors', [HomeController::class, 'getDoctors']);
Route::post('user/create-guest', [HomeController::class, 'storRegistrationAsGuest']);
