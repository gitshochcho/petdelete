@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Pet Breed</h1>
                <a href="{{ route('admin.pet-breeds.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pet-breeds.update', $petBreed) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pet_subcategory_id" class="form-label">Pet Subcategory <span class="text-danger">*</span></label>
                                    <select name="pet_subcategory_id" id="pet_subcategory_id" class="form-select @error('pet_subcategory_id') is-invalid @enderror">
                                        <option value="">Select Subcategory</option>
                                        @foreach($petSubcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('pet_subcategory_id', $petBreed->pet_subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->petCategory->name }} - {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pet_subcategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Breed Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $petBreed->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $petBreed->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="typical_weight_min" class="form-label">Minimum Weight (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="typical_weight_min" id="typical_weight_min" class="form-control @error('typical_weight_min') is-invalid @enderror" value="{{ old('typical_weight_min', $petBreed->typical_weight_min) }}" required>
                                    @error('typical_weight_min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="typical_weight_max" class="form-label">Maximum Weight (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="typical_weight_max" id="typical_weight_max" class="form-control @error('typical_weight_max') is-invalid @enderror" value="{{ old('typical_weight_max', $petBreed->typical_weight_max) }}" required>
                                    @error('typical_weight_max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', $petBreed->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $petBreed->status) == '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Breed</button>
                            <a href="{{ route('admin.pet-breeds.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
