@extends('admin.layouts.app')

@section('title', 'Main Content')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Main Content</h3>
                        <a href="{{ route('admin.main-contents.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mainContents as $index => $content)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($content->image)
                                                <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}" class="img-thumbnail" style="max-width: 80px; max-height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $content->title }}</td>
                                        <td>
                                            <label class="switch">
                                            <input type="checkbox" class="status-toggle" 
                                                data-id="{{ $content->id }}"
                                                {{ $content->is_active ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                            <span class="status-text">{{ $content->is_active ? 'Active' : 'Inactive' }}</span>
                                        </label>
                                        </td>
                                        <td>
                                            <div role="group">
                                                <a href="{{ route('admin.main-contents.edit', $content->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                   Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-item" data-id="{{ $content->id }}" data-toggle="tooltip" title="Delete">
                                                    Delete
                                                </button>
                                                <form id="delete-form-{{ $content->id }}" action="{{ route('admin.main-contents.destroy', $content->id) }}" method="POST" style="display: none;">
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
                                                <p class="mb-0">No main content found. Click the button above to add a new one.</p>
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
@endsection

@push('styles')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 90px;
            height: 34px;
        }
        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #28a745;
        }
        input:focus + .slider {
            box-shadow: 0 0 1px #28a745;
        }
        input:checked + .slider:before {
            transform: translateX(56px);
        }
        .status-text {
            position: absolute;
            top: 8px;
            left: 40px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            pointer-events: none;
        }
        input:checked + .slider + .status-text {
            left: 12px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Handle delete button click
            $('.delete-item').on('click', function() {
                const id = $(this).data('id');
                
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
                        $(`#delete-form-${id}`).submit();
                    }
                });
            });

            // Handle status toggle
            $('.status-toggle').on('change', function() {
                const id = $(this).data('id');
                const status = $(this).is(':checked');
                const $toggle = $(this);
                const $statusText = $toggle.siblings('.status-text');
                const $slider = $toggle.siblings('.slider');

                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin.main-contents.update-status") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: status ? 1 : 0
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the status text
                            $statusText.text(status ? 'Active' : 'Inactive');
                            // Toggle the slider color
                            $slider.css('background-color', status ? '#28a745' : '#dc3545');
                            toastr.success('Status updated successfully');
                        } else {
                            // Revert the toggle if update fails
                            $toggle.prop('checked', !status);
                            $statusText.text(status ? 'Inactive' : 'Active');
                            $slider.css('background-color', status ? '#dc3545' : '#28a745');
                            toastr.error('Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        // Revert the toggle on error
                        $toggle.prop('checked', !status);
                        $statusText.text(status ? 'Inactive' : 'Active');
                        $slider.css('background-color', status ? '#dc3545' : '#28a745');
                        toastr.error('An error occurred while updating status');
                    }
                });
        });
    });
</script>
@endpush
