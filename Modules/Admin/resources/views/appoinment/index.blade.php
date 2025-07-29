@extends('layouts.app')

@push('custome-css')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-group-sm > .btn, .btn-sm {
        margin-right: 5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Appointments</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($data->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Doctor Name</th>
                                        <th>Pet Name</th>
                                        <th>Owner</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->admin->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->pet->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->pet->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d H:i:s') }}</td>

                                            <td>
                                                <span class="badge
                                                    {{ $appointment->status == 1 ? 'bg-success' : ($appointment->status == 0 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $appointment->status == 0 ? 'Pending' : ($appointment->status == 1 ? 'Confirmed' : 'Cancelled') }}
                                                </span>
                                            </td>

                                                <td>
                                                    <span class="badge
                                                        {{ $appointment->type == 1 ? 'bg-primary' : ($appointment->type == 2 ? 'bg-secondary' : 'bg-info') }}">
                                                        {{ $appointment->type == 1 ? 'Chamber' : ($appointment->type == 2 ? 'Home' : 'Other') }}
                                                    </span>
                                                </td>
                                            <td>

                                                @if($appointment->status == 0)
                                                    <button class="btn btn-sm btn-success change-status-btn" data-id="{{ $appointment->id }}" data-status="1">Make Confirm</button>
                                                @elseif($appointment->status == 1)
                                                    <button class="btn btn-sm btn-warning change-status-btn" data-id="{{ $appointment->id }}" data-status="0">Make Pending</button>
                                                @endif

                                                <button class="btn btn-sm btn-danger delete-appointment-btn" data-id="{{ $appointment->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $data->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No appointments found.</p>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custome-js')
<script>
$(document).ready(function() {
    // CSRF Token setup for AJAX
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (!csrfToken) {
        console.error('CSRF token not found. Please ensure the meta tag is present in the layout.');
        showAlert('error', 'Security token not found. Please refresh the page.');
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // Change Status Button Click Event
    $('.change-status-btn').on('click', function() {
        const appointmentId = $(this).data('id');
        const newStatus = $(this).data('status');
        const button = $(this);

        // Confirm action
        const statusText = newStatus == 1 ? 'confirm' : 'pending';
        if (!confirm(`Are you sure you want to make this appointment ${statusText}?`)) {
            return;
        }

        // Disable button during request
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // AJAX Request
        $.ajax({
            url: '{{ route("admin.appointments.updateStatus") }}',
            type: 'POST',
            data: {
                appointment_id: appointmentId,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);

                    // Reload page to update status
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('error', response.message || 'Failed to update status');
                    button.prop('disabled', false);
                    resetButtonText(button, newStatus);
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Failed to update appointment status';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert('error', errorMessage);
                button.prop('disabled', false);
                resetButtonText(button, newStatus);
            }
        });
    });

    // Delete Appointment Button Click Event
    $('.delete-appointment-btn').on('click', function() {
        const appointmentId = $(this).data('id');
        const button = $(this);
        const row = button.closest('tr');

        // Confirm deletion
        if (!confirm('Are you sure you want to delete this appointment? This action cannot be undone.')) {
            return;
        }

        // Disable button during request
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

        // AJAX Request
        $.ajax({
            url: '{{ route("admin.appointments.delete") }}',
            type: 'DELETE',
            data: {
                appointment_id: appointmentId
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);

                    // Remove row from table with animation
                    row.fadeOut(500, function() {
                        $(this).remove();

                        // Check if table is empty
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                } else {
                    showAlert('error', response.message || 'Failed to delete appointment');
                    button.prop('disabled', false);
                    button.html('<i class="fas fa-trash"></i> Delete');
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Failed to delete appointment';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert('error', errorMessage);
                button.prop('disabled', false);
                button.html('<i class="fas fa-trash"></i> Delete');
            }
        });
    });

    // Helper function to reset button text
    function resetButtonText(button, status) {
        if (status == 1) {
            button.html('Make Confirm');
        } else {
            button.html('Make Pending');
        }
    }

    // Helper function to show alerts
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Remove existing alerts
        $('.alert').remove();

        // Add new alert at the top
        $('.container-fluid .row .col-12').prepend(alertHtml);

        // Auto-hide success alerts after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 5000);
        }
    }
});
</script>
@endpush
