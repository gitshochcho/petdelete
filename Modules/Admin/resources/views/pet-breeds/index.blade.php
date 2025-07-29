@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Pet Breeds</h1>
                <a href="{{ route('admin.pet-breeds.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Breed
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
                    @if($petBreeds->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Subcategory</th>
                                        <th>Category</th>
                                        <th>Weight Range</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($petBreeds as $breed)
                                        <tr>
                                            <td>{{ $breed->id }}</td>
                                            <td>{{ $breed->name }}</td>
                                            <td>{{ $breed->petSubcategory->name ?? 'N/A' }}</td>
                                            <td>{{ $breed->petSubcategory->petCategory->name ?? 'N/A' }}</td>
                                            <td>{{ $breed->typical_weight_min }} - {{ $breed->typical_weight_max }} kg</td>
                                            <td>
                                                <span class="badge {{ $breed->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $breed->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pet-breeds.show', $breed) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('admin.pet-breeds.edit', $breed) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.pet-breeds.destroy', $breed) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this breed?')">
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

                        {{ $petBreeds->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No pet breeds found.</p>
                            <a href="{{ route('admin.pet-breeds.create') }}" class="btn btn-primary">Create First Breed</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
