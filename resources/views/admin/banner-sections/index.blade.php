@extends('admin.layouts.app')

@section('title', 'Banner Sections')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Banner Sections</h4>
                    <a href="{{ route('admin.banner-sections.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Banner
                    </a>
                </div>

               
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Language</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @forelse($banners as $banner)

                            
                                <tr data-id="{{ $banner->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge {{ $banner->language == 'en' ? 'bg-primary' : 'bg-success' }}">
                                            {{ $banner->language_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 100px; max-height: 50px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banner-sections.edit', $banner->id) }}" class="text-primary">
                                            {{ $banner->title }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($banner->description, 50) }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" 
                                                data-id="{{ $banner->id }}" 
                                                id="status-{{ $banner->id }}"
                                                {{ $banner->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.banner-sections.edit', $banner->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-banner" data-id="{{ $banner->id }}" data-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $banner->id }}" action="{{ route('admin.banner-sections.destroy', $banner->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No banner sections found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        //$('[data-toggle="tooltip"]').tooltip();
        
        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle delete button click
        $('.delete-banner').click(function() {
            const bannerId = $(this).data('id');
            const form = $('#delete-form-' + bannerId);
            
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
            const bannerId = $(this).data('id');
            const isActive = $(this).is(':checked') ? 1 : 0;
            const $switch = $(this);
            
            // Show loading state
            $switch.prop('disabled', true);
            
            // Send AJAX request to update status
            $.ajax({
                url: '{{ route("admin.banner-sections.update-status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: bannerId,
                    status: isActive
                },
                success: function(response) {
                    // Show success popup
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'Status updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function(xhr) {
                    // Revert toggle on error
                    $switch.prop('checked', !isActive);
                    
                    // Show error popup
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while updating status',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
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
