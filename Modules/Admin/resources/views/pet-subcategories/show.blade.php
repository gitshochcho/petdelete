@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pet Subcategory Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pet-subcategories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.pet-subcategories.edit', $petSubcategory) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="200">ID:</th>
                                        <td>{{ $petSubcategory->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pet Category:</th>
                                        <td>
                                            <span class="badge bg-info">{{ $petSubcategory->petCategory->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Subcategory Name:</th>
                                        <td><strong>{{ $petSubcategory->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge {{ $petSubcategory->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $petSubcategory->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>{{ $petSubcategory->created_at->format('F d, Y \a\t h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At:</th>
                                        <td>{{ $petSubcategory->updated_at->format('F d, Y \a\t h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Description</h5>
                                </div>
                                <div class="card-body">
                                    @if($petSubcategory->description)
                                        <p class="mb-0">{{ $petSubcategory->description }}</p>
                                    @else
                                        <em class="text-muted">No description provided.</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($petSubcategory->petBreeds->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-paw"></i> Pet Breeds in this Subcategory
                                            <span class="badge bg-primary">{{ $petSubcategory->petBreeds->count() }}</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Breed Name</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($petSubcategory->petBreeds as $breed)
                                                        <tr>
                                                            <td>{{ $breed->id }}</td>
                                                            <td>{{ $breed->name }}</td>
                                                            <td>
                                                                <span class="badge {{ $breed->status ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $breed->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $breed->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.pet-breeds.show', $breed) }}" class="btn btn-info btn-xs">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('admin.pet-breeds.edit', $breed) }}" class="btn btn-warning btn-xs">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('admin.pet-subcategories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.pet-subcategories.edit', $petSubcategory) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Subcategory
                        </a>
                        <form action="{{ route('admin.pet-subcategories.destroy', $petSubcategory) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custome-js')

@endpush
