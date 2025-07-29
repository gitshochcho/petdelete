<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;

class AdminController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    // ====================================
    // APPOINTMENT MANAGEMENT METHODS
    // ====================================

    /**
     * Update appointment status via AJAX
     */
    public function updateAppointmentStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'appointment_id' => 'required|exists:appointments,id',
                'status' => 'required|in:0,1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data provided',
                    'errors' => $validator->errors()
                ], 422);
            }

            $appointment = Appointment::find($request->appointment_id);

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            // Update the status
            $appointment->status = $request->status;
            $appointment->save();

            $statusText = $request->status == 1 ? 'confirmed' : 'pending';

            return response()->json([
                'success' => true,
                'message' => "Appointment status updated to {$statusText} successfully",
                'data' => [
                    'appointment_id' => $appointment->id,
                    'new_status' => $appointment->status,
                    'status_text' => $statusText
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update appointment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete appointment via AJAX
     */
    public function deleteAppointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'appointment_id' => 'required|exists:appointments,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid appointment ID provided',
                    'errors' => $validator->errors()
                ], 422);
            }

            $appointment = Appointment::find($request->appointment_id);

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            // Store appointment info before deletion
            $appointmentInfo = [
                'id' => $appointment->id,
                'user_name' => $appointment->user->name ?? 'N/A',
                'pet_name' => $appointment->pet->name ?? 'N/A'
            ];

            // Delete the appointment
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully',
                'data' => $appointmentInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get appointment details via AJAX
     */
    public function getAppointmentDetails(Request $request, $id)
    {
        try {
            $appointment = Appointment::with(['user', 'admin', 'pet'])
                ->find($id);

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $appointment,
                'message' => 'Appointment details retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get appointment details: ' . $e->getMessage()
            ], 500);
        }
    }
}
