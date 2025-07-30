@extends('layouts.app')

@push('custome-css')

@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Pet Details</h1>
                <div>
                    <a href="{{ route('user.pets.edit', $pet) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('user.pets.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Pet Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Pet Name:</th>
                                            <td>{{ $pet->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Owner:</th>
                                            <td>{{ $pet->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category:</th>
                                            <td>{{ $pet->petCategory->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subcategory:</th>
                                            <td>{{ $pet->petSubcategory->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Breed:</th>
                                            <td>{{ $pet->petBreed->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Birthday:</th>
                                            <td>{{ $pet->birthday?->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age:</th>
                                            <td>{{ \Carbon\Carbon::parse($pet->birthday)->age }} years</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Weight:</th>
                                            <td>{{ $pet->weight }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Sex:</th>
                                            <td>{{ ucfirst($pet->sex) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="badge {{ $pet->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $pet->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $pet->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated:</th>
                                            <td>{{ $pet->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Health Information</h5>
                        </div>
                        <div class="card-body">
                            @if($pet->current_medications)
                                <div class="mb-3">
                                    <h6>Current Medications</h6>
                                    <p class="text-muted">{{ $pet->current_medications }}</p>
                                </div>
                            @endif

                            @if($pet->medication_allergies)
                                <div class="mb-3">
                                    <h6>Medication Allergies</h6>
                                    <p class="text-muted">{{ $pet->medication_allergies }}</p>
                                </div>
                            @endif

                            @if($pet->health_conditions)
                                <div class="mb-3">
                                    <h6>Health Conditions</h6>
                                    <p class="text-muted">{{ $pet->health_conditions }}</p>
                                </div>
                            @endif

                            @if($pet->special_notes)
                                <div class="mb-3">
                                    <h6>Special Notes</h6>
                                    <p class="text-muted">{{ $pet->special_notes }}</p>
                                </div>
                            @endif

                            @if(!$pet->current_medications && !$pet->medication_allergies && !$pet->health_conditions && !$pet->special_notes)
                                <p class="text-muted">No health information available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
