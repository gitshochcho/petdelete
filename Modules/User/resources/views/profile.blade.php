@extends('layouts.app')

@push('custome-css')

@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Dashboard</h1>
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
            {{ $user }}
            <h2 class="mb-4">Profile Information</h2>}}
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.profile.update', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_address" class="form-label">Address</label>
                                    <input type="text" name="full_address" id="full_address" class="form-control @error('full_address') is-invalid @enderror" value="{{ old('full_address', $userDetail->full_address) }}">
                                    @error('full_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="birth_certificate" class="form-label">Birth Certificate </label>
                                    <input type="text" name="birth_certificate" id="birth_certificate" class="form-control @error('birth_certificate') is-invalid @enderror" value="{{ old('birth_certificate', $userDetail->birth_certificate) }}" required>
                                    @error('birth_certificate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nid" class="form-label">NID <span class="text-danger">*</span></label>
                                    <input type="text" name="nid" id="nid" class="form-control @error('nid') is-invalid @enderror" value="{{ old('nid', $userDetail->nid) }}" required>
                                    @error('nid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="passport" class="form-label">Passport </label>
                                    <input type="text" name="passport" id="passport" class="form-control @error('passport') is-invalid @enderror" value="{{ old('passport', $userDetail->passport) }}">
                                    @error('passport')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                @if($user->hasMedia('profile') && $user->getFirstMediaUrl('profile'))
                                    <div class="mt-2">
                                        <img src="{{ $user->getFirstMediaUrl('profile') }}"
                                                alt="Current Profile" class="img-thumbnail" style="max-width: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
