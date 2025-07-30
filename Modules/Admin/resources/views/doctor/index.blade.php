@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Veterinary Doctors</h1>
                {{-- <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Service
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
                    @if($doctors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>BVC Reg. Number</th>
                                        <th>Chamber Visit</th>
                                        <th>Home Visit</th>
                                        <th>Address</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->id }}</td>
                                            <td>{{ $doctor->name }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td>{{ $doctor->phone }}</td>
                                            <td>{{ $doctor->bvc_reg_number }}</td>
                                            <td>{{ number_format($doctor->chamber_visit, 2) }}</td>
                                            <td>${{ number_format($doctor->home_visit, 2) }}</td>
                                            <td>{{ Str::limit($doctor->full_address, 50) }}</td>

                                            {{-- <td>
                                                <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this doctor?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $doctors->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No Veterinary Doctors found.</p>
                            {{-- <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">Create First Doctor</a> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
