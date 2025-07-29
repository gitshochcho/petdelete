@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Pets</h1>
                <a href="{{ route('admin.pets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Pet
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($pets->count() > 0)
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
                                    @foreach($pets as $pet)
                                        <tr>
                                            <td>{{ $pet->id }}</td>
                                            <td>{{ $pet->name }}</td>
                                            <td>{{ $pet->user->name ?? 'N/A' }}</td>
                                            <td>{{ $pet->petCategory->name ?? 'N/A' }}</td>
                                            <td>{{ $pet->petBreed->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pet->birthday)->age }} years</td>
                                            <td>{{ $pet->weight }} kg</td>
                                            <td>{{ ucfirst($pet->sex) }}</td>
                                            <td>
                                                <span class="badge {{ $pet->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $pet->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pets.show', $pet) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('admin.pets.edit', $pet) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pet?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
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
                            <a href="{{ route('admin.pets.create') }}" class="btn btn-primary">Add First Pet</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
