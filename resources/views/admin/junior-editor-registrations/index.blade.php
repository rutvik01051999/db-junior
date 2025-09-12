@extends('admin.layouts.app')

@section('title', 'Junior Editor Registrations')

@section('content')
    <!-- Page Header -->
    {{-- @include('admin.layouts.partials.page-header', [
        'title' => 'Junior Editor Registrations',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Junior Editor Registrations' => route('admin.junior-editor-registrations.index'),
        ],
    ]) --}}

    @include('admin.layouts.partials.alert')

    <!-- Filter -->
    <div class="row collapse" id="filter-canvas">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Filter Registrations
                    </div>
                    <div class="d-flex align-items-center justify-content-end flex-wrap">
                        <a data-bs-toggle="collapse" href="#filter-canvas" role="button" aria-expanded="false"
                            aria-controls="filter-canvas" class="text-danger d-flex align-items-center">
                            <i class="bx bx-x bx-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="payment_status">Payment Status</label>
                                    <select name="payment_status" id="payment_status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" name="startDate" id="startDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="endDate">End Date</label>
                                    <input type="date" name="endDate" id="endDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary btn-sm" id="apply-filter">
                                            <i class="bx bx-filter"></i> Apply Filter
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="clear-filter">
                                            <i class="bx bx-x"></i> Clear
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

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Junior Editor Registrations
                    </div>
                    <div class="btn-canvas d-flex align-items-center justify-content-end flex-wrap">
                        <div class="action-buttons flex-wrap btn-group-sm">
                            <a data-bs-toggle="collapse" href="#filter-canvas" role="button" aria-expanded="false"
                                aria-controls="filter-canvas" class="btn btn-sm btn-dark">
                                <span class="d-flex align-items-center">
                                    <i class="bx bx-filter bx-xs"></i>
                                    Filter
                                </span>
                            </a>
                            <a href="{{ route('admin.junior-editor-registrations.export') }}" class="btn btn-sm btn-success">
                                <span class="d-flex align-items-center">
                                    <i class="bx bx-download bx-xs"></i>
                                    Export CSV
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table([
                            'class' => 'w-100 table-striped table-hover table-bordered',
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    
    <script>
        $(document).ready(function() {
            // Apply filter
            $('#apply-filter').click(function() {
                var table = $('#junior-editor-registrations-table').DataTable();
                table.ajax.reload();
            });

            // Clear filter
            $('#clear-filter').click(function() {
                $('#filter-form')[0].reset();
                var table = $('#junior-editor-registrations-table').DataTable();
                table.ajax.reload();
            });

            // Auto-apply filter on date change
            $('#startDate, #endDate, #payment_status').change(function() {
                var table = $('#junior-editor-registrations-table').DataTable();
                table.ajax.reload();
            });

            // Handle payment status update
            $(document).on('click', '.update-payment-status', function() {
                const registrationId = $(this).data('id');
                const newStatus = $(this).data('status');
                const $button = $(this);
                
                Swal.fire({
                    title: 'Update Payment Status',
                    text: `Are you sure you want to mark this registration as ${newStatus}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        $button.prop('disabled', true);
                        
                        // Send AJAX request
                        $.ajax({
                            url: '{{ route("admin.junior-editor-registrations.update-payment-status") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: registrationId,
                                payment_status: newStatus
                            },
                            success: function(response) {
                                // Show success message
                                Swal.fire({
                                    title: 'Updated!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    // Reload the DataTable
                                    var table = $('#junior-editor-registrations-table').DataTable();
                                    table.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                // Show error message
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'An error occurred while updating payment status.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#d33'
                                });
                            },
                            complete: function() {
                                // Re-enable the button
                                $button.prop('disabled', false);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
