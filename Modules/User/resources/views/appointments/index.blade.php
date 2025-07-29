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
                                        <th>Pet Name</th>
                                        <th>Owner</th>
                                        <th>Category</th>
                                        <th>Breed</th>
                                        <th>Age</th>
                                        <th>Weight</th>
                                        <th>Sex</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->pet->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->pet->petCategory->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->pet->petBreed->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->pet->birthday)->age }} years</td>
                                            <td>{{ $appointment->pet->weight }} kg</td>
                                            <td>{{ ucfirst($appointment->pet->sex) }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $appointment->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.pets.show', $appointment->pet) }}" class="btn btn-sm btn-info">View</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $pets->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No pets found.</p>
                            <a href="{{ route('user.pets.create') }}" class="btn btn-primary">Add First Pet</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
