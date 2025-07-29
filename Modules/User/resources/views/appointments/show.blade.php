@extends('layouts.app')

@push('custome-css')
<style>
    .appointment-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .card-header {
        background: #4a90e2;
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 20px 25px;
        border: none;
    }

    .appointment-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 500;
    }

    .appointment-id {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .detail-row {
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #555;
        width: 150px;
        flex-shrink: 0;
    }

    .detail-value {
        color: #333;
        font-weight: 500;
    }

    .simple-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .notes-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .notes-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .notes-text {
        color: #6c757d;
        line-height: 1.5;
        margin: 0;
    }

    .back-button {
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .back-button:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Appointment Details</h3>
                <a href="{{ route('user.appointments.index') }}" class="back-button">
                    ← Back to Appointments
                </a>
            </div>

            <div class="card appointment-card">
                <div class="card-header">
                    <div class="appointment-id">Appointment #{{ $appointment->id }}</div>
                    <h4 class="appointment-title">{{ $appointment->admin->name ?? 'Veterinary Appointment' }}</h4>
                </div>

                <div class="card-body" style="padding: 25px;">
                    <div class="detail-row">
                        <div class="detail-label">Doctor:</div>
                        <div class="detail-value">{{ $appointment->admin->name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Pet Name:</div>
                        <div class="detail-value">{{ $appointment->pet->name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Owner:</div>
                        <div class="detail-value">{{ $appointment->pet->user->name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Date & Time:</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y - g:i A') }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Status:</div>
                        <div class="detail-value">
                            <span class="simple-badge
                                {{ $appointment->status == 1 ? 'bg-success text-white' : ($appointment->status == 0 ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                                {{ $appointment->status == 0 ? 'Pending' : ($appointment->status == 1 ? 'Confirmed' : 'Cancelled') }}
                            </span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Type:</div>
                        <div class="detail-value">
                            <span class="simple-badge
                                {{ $appointment->type == 1 ? 'bg-primary text-white' : ($appointment->type == 2 ? 'bg-secondary text-white' : 'bg-info text-white') }}">
                                {{ $appointment->type == 1 ? 'Chamber Visit' : ($appointment->type == 2 ? 'Home Visit' : 'Other') }}
                            </span>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <div class="notes-card">
                            <div class="notes-title">Notes</div>
                            <p class="notes-text">{{ $appointment->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
