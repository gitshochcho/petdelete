@extends('layouts.app')

@push('custome-css')

@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Add New Pet</h1>
                <a href="{{ route('user.pets.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.pets.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Owner <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                        <option value="">Select Owner</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($petCategories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="subcategory_id" class="form-label">Subcategory <span class="text-danger">*</span></label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-select @error('subcategory_id') is-invalid @enderror">
                                        <option value="">Select Subcategory</option>
                                        @foreach($petSubcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="breed_id" class="form-label">Breed <span class="text-danger">*</span></label>
                                    <select name="breed_id" id="breed_id" class="form-select @error('breed_id') is-invalid @enderror">
                                        <option value="">Select Breed</option>
                                        @foreach($petBreeds as $breed)
                                            <option value="{{ $breed->id }}" {{ old('breed_id') == $breed->id ? 'selected' : '' }}>
                                                {{ $breed->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('breed_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                                    <input type="date" name="birthday" id="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}" required>
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="weight" class="form-label">Weight (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}" required>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                    <select name="sex" id="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                        <option value="">Select Sex</option>
                                        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('sex')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_medications" class="form-label">Current Medications</label>
                                    <textarea name="current_medications" id="current_medications" rows="3" class="form-control @error('current_medications') is-invalid @enderror">{{ old('current_medications') }}</textarea>
                                    @error('current_medications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="medication_allergies" class="form-label">Medication Allergies</label>
                                    <textarea name="medication_allergies" id="medication_allergies" rows="3" class="form-control @error('medication_allergies') is-invalid @enderror">{{ old('medication_allergies') }}</textarea>
                                    @error('medication_allergies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="health_conditions" class="form-label">Health Conditions</label>
                                    <textarea name="health_conditions" id="health_conditions" rows="3" class="form-control @error('health_conditions') is-invalid @enderror">{{ old('health_conditions') }}</textarea>
                                    @error('health_conditions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="special_notes" class="form-label">Special Notes</label>
                                    <textarea name="special_notes" id="special_notes" rows="3" class="form-control @error('special_notes') is-invalid @enderror">{{ old('special_notes') }}</textarea>
                                    @error('special_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Add Pet</button>
                            <a href="{{ route('user.pets.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
