@extends('admin.layouts.app')

@section('title', 'Banner Sections')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Banner Sections</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.banner-sections.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Banner
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
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
                                        <label class="switch">
                                            <input type="checkbox" class="status-toggle" 
                                                data-id="{{ $banner->id }}"
                                                {{ $banner->is_active ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                            <span class="status-text">{{ $banner->is_active ? 'Active' : 'Inactive' }}</span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banner-sections.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $banner->id }}">
                                            Delete
                                        </button>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this banner?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('scripts')
    <!-- jQuery and jQuery UI must be loaded first -->
  
    
    <!-- Toastr for notifications -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(function() {
            // Delete button click handler
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                var url = '{{ route("admin.banner-sections.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#deleteModal').modal('show');
            });

            // Status toggle handler
            $('.status-toggle').change(function() {
                var $toggle = $(this);
                var $switch = $toggle.closest('.switch');
                var id = $toggle.data('id');
                var status = $toggle.prop('checked');
                var $statusText = $switch.find('.status-text');
                var $slider = $switch.find('.slider');
                
                // Update UI immediately for better UX
                $statusText.text(status ? 'Active' : 'Inactive');
                $slider.css('background-color', status ? '#28a745' : '#dc3545');
                
                $.ajax({
                    url: '{{ route("admin.banner-sections.update-status") }}',
                    type: 'POST',
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

            // Make sure jQuery UI is loaded
            // if (typeof jQuery.ui !== 'undefined' && jQuery.ui.sortable) {
            //     // Initialize sortable with handle
            //     $("#sortable").sortable({
            //         handle: 'td', // Make entire row draggable
            //         cursor: 'move',
            //         opacity: 0.7,
            //         update: function(event, ui) {
            //             var order = [];
            //             $("#sortable tr").each(function(index) {
            //                 order.push({
            //                     id: $(this).data('id'),
            //                     position: index + 1
            //                 });
            //             });

            //             $.ajax({
            //                 url: '{{ route("admin.banner-sections.order") }}',
            //                 type: 'POST',
            //                 data: {
            //                     _token: '{{ csrf_token() }}',
            //                     order: order
            //                 },
            //                 success: function(response) {
            //                     if (response.success) {
            //                         toastr.success(response.message);
            //                     } else {
            //                         toastr.error(response.message || 'Failed to update order');
            //                         location.reload();
            //                     }
            //                 },
            //                 error: function(xhr) {
            //                     toastr.error('An error occurred while updating the order.');
            //                     location.reload();
            //                 }
            //             });
            //         }
            //     });
                
            //     // Disable text selection while dragging
            //     $("#sortable").disableSelection();
            // } else {
            //     console.error('jQuery UI Sortable not loaded');
            // }
        });
    </script>
@endpush
