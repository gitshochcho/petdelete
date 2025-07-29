@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>

                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Basic Information</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                                           id="profile_image" name="profile_image" accept="image/*">
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($admin->hasMedia('profile') && $admin->getFirstMediaUrl('profile'))
                                        <div class="mt-2">
                                            <img src="{{ $admin->getFirstMediaUrl('profile') }}"
                                                 alt="Current Profile" class="img-thumbnail" style="max-width: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="full_address" class="form-label">Full Address</label>
                                    <textarea class="form-control @error('full_address') is-invalid @enderror"
                                              id="full_address" name="full_address" rows="3"
                                              placeholder="Enter your complete address">{{ old('full_address', $admin->full_address ?? '') }}</textarea>
                                    @error('full_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Specific Fields -->
                        @if($admin->hasRole('doctor'))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-success mb-3"><i class="fas fa-user-md"></i> Doctor Information</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="degree" class="form-label">Degree/Qualification</label>
                                        <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                               id="degree" name="degree"
                                               value="{{ old('degree', $admin->degree ?? '') }}"
                                               placeholder="e.g., MBBS, BVSc, PhD">
                                        @error('degree')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bvc_reg_number" class="form-label">BVC Registration Number</label>
                                        <input type="text" class="form-control @error('bvc_reg_number') is-invalid @enderror"
                                               id="bvc_reg_number" name="bvc_reg_number"
                                               value="{{ old('bvc_reg_number', $admin->bvc_reg_number ?? '') }}"
                                               placeholder="Enter BVC registration number">
                                        @error('bvc_reg_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="home_visit" class="form-label">Home Visit Fee</label>
                                        <input type="number" class="form-control @error('home_visit') is-invalid @enderror"
                                               id="home_visit" name="home_visit"
                                               value="{{ old('home_visit', $admin->home_visit ?? '') }}"
                                               min="0" placeholder="Enter home visit fee">
                                        @error('home_visit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="chamber_visit" class="form-label">Chamber Visit Fee</label>
                                        <input type="number" class="form-control @error('chamber_visit') is-invalid @enderror"
                                               id="chamber_visit" name="chamber_visit"
                                               value="{{ old('chamber_visit', $admin->chamber_visit ?? '') }}"
                                               min="0" placeholder="Enter chamber visit fee">
                                        @error('chamber_visit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.profile.change-password') }}" class="btn btn-outline-warning">
                                        <i class="fas fa-lock"></i> Change Password
                                    </a>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custome-js')
<script>
    // Preview image on selection
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const existingPreview = document.querySelector('.image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                const preview = document.createElement('div');
                preview.className = 'mt-2 image-preview';
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 100px;">`;
                document.getElementById('profile_image').parentNode.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
