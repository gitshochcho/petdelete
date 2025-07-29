@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Service Details</h1>
                <div>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="25%">ID:</th>
                                    <td>{{ $service->id }}</td>
                                </tr>
                                <tr>
                                    <th>Service Name:</th>
                                    <td>{{ $service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Base Price:</th>
                                    <td>${{ number_format($service->base_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Estimated Duration:</th>
                                    <td>{{ $service->estimated_duration }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $service->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $service->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
