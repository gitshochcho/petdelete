@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Appointments</h1>
                {{-- <a href="{{ route('user.pets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Pet
                </a> --}}
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($appointments->count() > 0)
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
                                    @foreach($appointments as $appointment)
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
                                                <a href="{{ route('user.appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $appointments->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No appointments found.</p>
                            {{-- <a href="{{ route('user.appointments.create') }}" class="btn btn-primary">Add First Appointment</a> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
