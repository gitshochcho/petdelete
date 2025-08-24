@extends('layouts.app')

@push('custome-css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Veterinary Doctors</h1>
                {{-- <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Service
                </a> --}}
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($doctors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>BVC Reg. Number</th>
                                        <th>Chamber Visit</th>
                                        <th>Home Visit</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->id }}</td>
                                            <td>{{ $doctor->name }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td>{{ $doctor->phone }}</td>
                                            <td>{{ $doctor->bvc_reg_number }}</td>
                                            <td>{{ number_format($doctor->chamber_visit, 2) }}</td>
                                            <td>${{ number_format($doctor->home_visit, 2) }}</td>
                                            <td>{{ Str::limit($doctor->full_address, 50) }}</td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" 
                                                           id="statusSwitch{{ $doctor->id }}" 
                                                           {{ $doctor->status == 1 ? 'checked' : '' }}
                                                           onchange="toggleStatus({{ $doctor->id }}, this.checked)">
                                                    <label class="form-check-label" for="statusSwitch{{ $doctor->id }}">
                                                        {{ $doctor->status == 1 ? 'Active' : 'Inactive' }}
                                                    </label>
                                                </div>

                                                {{-- <div class="mt-2">
                                                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-info">View</a>
                                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this doctor?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div> --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $doctors->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No Veterinary Doctors found.</p>
                            {{-- <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">Create First Doctor</a> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custome-js')
    <script>
        function showSuccessMessage(message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Add to body
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        function showErrorMessage(message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Add to body
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        function toggleStatus(doctorId, isChecked) {
            const status = isChecked ? 1 : 0;
            
            fetch(`/doctors/${doctorId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = document.querySelector(`label[for="statusSwitch${doctorId}"]`);
                    label.textContent = status === 1 ? 'Active' : 'Inactive';
                    
                    // Show success message
                    showSuccessMessage(data.message || 'Doctor status updated successfully');
                } else {
                    // Show error message and revert checkbox
                    showErrorMessage(data.message || 'Failed to update status');
                    document.querySelector(`input[onchange*="${doctorId}"]`).checked = !isChecked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An error occurred while updating status');
                // Revert checkbox on error
                document.querySelector(`input[onchange*="${doctorId}"]`).checked = !isChecked;
            });
        }
    </script>
@endpush
