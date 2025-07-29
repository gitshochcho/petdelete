@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pet Subcategories</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pet-subcategories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Subcategory
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petSubcategories as $subcategory)
                                    <tr>
                                        <td>{{ $subcategory->id }}</td>
                                        <td>{{ $subcategory->petCategory->name }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ Str::limit($subcategory->description, 50) }}</td>
                                        <td>
                                            <span class="badge {{ $subcategory->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $subcategory->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $subcategory->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.pet-subcategories.show', $subcategory) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.pet-subcategories.edit', $subcategory) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.pet-subcategories.destroy', $subcategory) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No pet subcategories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $petSubcategories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
