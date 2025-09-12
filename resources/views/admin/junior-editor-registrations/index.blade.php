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
    <div class="row collapse show" id="filter-canvas">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Filter Registrations
                    </div>
                    {{-- <div class="d-flex align-items-center justify-content-end flex-wrap">
                        <a data-bs-toggle="collapse" href="#filter-canvas" role="button" aria-expanded="false"
                            aria-controls="filter-canvas" class="text-danger d-flex align-items-center">
                            <i class="bx bx-x bx-sm"></i>
                        </a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" name="startDate" id="startDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="endDate">End Date</label>
                                    <input type="date" name="endDate" id="endDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="">All States</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="">All Cities</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary btn-sm" id="apply-filter">
                                            <i class="bx bx-filter"></i> Apply Filter
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

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    /* Select2 Custom Styling */
    .select2-container { width: 100% !important; }
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 38px;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
        padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        padding-right: 0;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    
    <script>
        $(document).ready(function() {


            let today = new Date().toISOString().split('T')[0];

// Set default value
$("#startDate").val(today);
$("#endDate").val(today);
            // Load states from database using existing route
            $.ajax({
                type: 'GET',
                url: '{{ route("junior-editor.states") }}',
                success: function(response) {
                    if (response.status === 'success') {
                        let options = "<option value=''>All States</option>";
                        $.each(response.data, function(index, val) {
                            options += "<option value='" + val.name + "'>" + val.name + "</option>";
                        });
                        $('#state').html(options);
                        
                        // Initialize Select2 for state dropdown after loading options
                        $('#state').select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select State',
                            allowClear: true,
                            width: '100%'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('States error:', error);
                    $('#state').html("<option value=''>No State Available</option>");
                }
            });

            // Initialize Select2 for city dropdown
            $('#city').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select City',
                allowClear: true,
                width: '100%'
            });

            // Load cities when state changes using existing route
            $('#state').on('change', function() {
                const state = $(this).val();
                
                if (!state) {
                    $('#city').html("<option value=''>All Cities</option>");
                    return;
                }
                
                $.ajax({
                    type: 'POST',
                    url: '{{ route("junior-editor.cities") }}',
                    data: {
                        state: state,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let options = "<option value=''>All Cities</option>";
                            $.each(response.data, function(index, val) {
                                options += "<option value='" + val.name + "'>" + val.name + "</option>";
                            });
                            $('#city').html(options);
                        } else {
                            $('#city').html("<option value=''>No City Available</option>");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Cities error:', error);
                        $('#city').html("<option value=''>No City Available</option>");
                    }
                });
            });

            // Apply filter
            $('#apply-filter').click(function() {
                console.log('Apply filter clicked');
                console.log('Filter values:', {
                    payment_status: $('#payment_status').val(),
                    startDate: $('#startDate').val(),
                    endDate: $('#endDate').val(),
                    state: $('#state').val(),
                    city: $('#city').val()
                });
                var table = $('#junior-editor-registrations-table').DataTable();
                table.ajax.reload(null, false); // false = stay on current page
            });

            // Auto-apply filter on field change
            $('#startDate, #endDate, #payment_status, #state, #city').change(function() {
                var table = $('#junior-editor-registrations-table').DataTable();
                table.ajax.reload(null, false); // false = stay on current page
            });

            // Override DataTable AJAX data function to include filter parameters
            $('#junior-editor-registrations-table').on('preXhr.dt', function (e, settings, data) {
                console.log('DataTable AJAX request - adding filter parameters');
                data.payment_status = $('#payment_status').val();
                data.startDate = $('#startDate').val();
                data.endDate = $('#endDate').val();
                data.state = $('#state').val();
                data.city = $('#city').val();
                console.log('Filter data being sent:', {
                    payment_status: data.payment_status,
                    startDate: data.startDate,
                    endDate: data.endDate,
                    state: data.state,
                    city: data.city
                });
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
