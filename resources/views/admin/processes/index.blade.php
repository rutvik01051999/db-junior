@extends('admin.layouts.app')

@section('title', 'Processes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Processes</h4>
                    <a href="{{ route('admin.processes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Process
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Language</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Steps</th>
                                    <th>Status</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($processes as $process)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge {{ $process->language == 'en' ? 'bg-primary' : 'bg-success' }}">
                                                {{ $process->language_name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($process->image)
                                                <img src="{{ $process->image_url }}" alt="{{ $process->title }}" width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $process->title }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $process->steps->count() }} step{{ $process->steps->count() !== 1 ? 's' : '' }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                    data-id="{{ $process->id }}" 
                                                    id="status-{{ $process->id }}"
                                                    {{ $process->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.processes.edit', $process->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-process" data-id="{{ $process->id }}" data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $process->id }}" action="{{ route('admin.processes.destroy', $process->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="mb-0">No processes found. Click the button above to add a new one.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .form-switch .form-check-input {
        width: 2.5em;
        margin-left: -2.5em;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
        background-position: left center;
        border-radius: 2em;
        transition: background-position 0.15s ease-in-out;
    }
    .form-switch .form-check-input:checked {
        background-position: right center;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
    .btn-group .btn {
        margin-right: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle delete button click
        $('.delete-process').click(function() {
            const processId = $(this).data('id');
            const form = $('#delete-form-' + processId);
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Handle status toggle switch
        $('.status-toggle').change(function() {
            console.log('Status toggle changed');
            const processId = $(this).data('id');
            const isActive = $(this).is(':checked') ? 1 : 0;
            const $switch = $(this);
            
            // Show loading state
            $switch.prop('disabled', true);
            
            // Send AJAX request to update status
            $.ajax({
                url: '{{ route("admin.processes.update-status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: processId,
                    status: isActive
                },
                success: function(response) {
                    // Show success message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: response.message || 'Status updated successfully'
                    });
                },
                error: function(xhr) {
                    // Revert toggle on error
                    $switch.prop('checked', !isActive);
                    
                    // Show error message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                    
                    Toast.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'An error occurred while updating status'
                    });
                },
                complete: function() {
                    // Re-enable the switch
                    $switch.prop('disabled', false);
                }
            });
        });
        
        // SweetAlert2 toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@endpush
