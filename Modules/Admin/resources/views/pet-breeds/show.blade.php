@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Pet Breed Details</h1>
                <div>
                    <a href="{{ route('admin.pet-breeds.edit', $petBreed) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('admin.pet-breeds.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $petBreed->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $petBreed->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $petBreed->petSubcategory->petCategory->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Subcategory:</th>
                                    <td>{{ $petBreed->petSubcategory->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Weight Range:</th>
                                    <td>{{ $petBreed->typical_weight_min }} - {{ $petBreed->typical_weight_max }} kg</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge {{ $petBreed->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $petBreed->status ? 'Active' : 'Disabled' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $petBreed->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $petBreed->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($petBreed->description)
                                <h5>Description</h5>
                                <p class="text-muted">{{ $petBreed->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
