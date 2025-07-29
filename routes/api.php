<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Appointment API Routes

    // Get all appointments for authenticated user
    Route::get('/appointments', [HomeController::class, 'getAppointments']);

    // Create new appointment
    Route::post('/appointments', [HomeController::class, 'createAppointment']);

    // Get specific appointment
    Route::get('/appointments/{id}', [HomeController::class, 'getAppointment']);

    // Update appointment (only if pending)
    Route::put('/appointments/{id}', [HomeController::class, 'updateAppointment']);

    // Cancel appointment (only if pending)
    Route::delete('/appointments/{id}', [HomeController::class, 'cancelAppointment']);

    // Get available doctors
    Route::get('/doctors', [HomeController::class, 'getAvailableDoctors']);

    // Get user's pets
    Route::get('/user/pets', [HomeController::class, 'getUserPets']);

