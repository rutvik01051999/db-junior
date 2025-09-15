@extends('admin.layouts.app')

@section('title', 'Winner Management')

@section('content')
<div class="container-fluid">
    @include('admin.layouts.partials.page-header', [
        'title' => 'Winner Management',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Winner Management' => '#'
        ]
    ])

    <!-- CSV Upload Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Upload Winners CSV</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#csvFormatModal">
                            <i class="fas fa-info-circle"></i> CSV Format Help
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <x-csv-upload 
                                    name="csv_file" 
                                    label="Select CSV File" 
                                    :required="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block" id="uploadBtn">
                                        <i class="fas fa-upload"></i> Upload CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Winners List Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Winners List</h3>
                </div>
                <div class="card-body">
                    {!! $dataTable->table(['class' => 'table table-striped table-bordered', 'style' => 'width:100%']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSV Format Help Modal -->
<div class="modal fade" id="csvFormatModal" tabindex="-1" role="dialog" aria-labelledby="csvFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="csvFormatModalLabel">
                    <i class="fas fa-file-csv me-2"></i>CSV Format Guide
                </h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">CSV Columns (in order):</h6>
                        <ul class="list-unstyled">
                            <li><strong class="text-danger">1. Name*</strong> - Winner's full name (2-100 characters, letters only)</li>
                            <li><strong>2. Email</strong> - Valid email address (optional)</li>
                            <li><strong class="text-danger">3. Mobile Number*</strong> - 10-digit mobile number (starting with 6,7,8,9)</li>
                            <li><strong>4. Created Date</strong> - Date in YYYY-MM-DD format (optional)</li>
                        </ul>
                        <small class="text-danger"><strong>* Mandatory fields</strong></small>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Example CSV:</h6>
                        <div class="bg-light p-3 rounded">
                            <code>
                                John Doe,john@example.com,6123456789,2024-01-15<br>
                                Jane Smith,jane@example.com,7234567890,2024-01-16<br>
                                Mike Johnson,,8345678901,2024-01-17<br>
                                Sarah Wilson,sarah@example.com,9456789012,2024-01-18<br>
                                David Brown,,6567890123,2024-01-19
                            </code>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Important Notes:</h6>
                    <ul class="mb-0">
                        <li><strong class="text-danger">Name and Mobile Number are mandatory</strong></li>
                        <li>Use comma (,) as separator</li>
                        <li>First row should contain data, not headers</li>
                        <li><strong class="text-warning">Mobile numbers must be unique</strong> - no duplicates allowed</li>
                        <li>Mobile numbers must be valid (10 digits, starting with 6,7,8,9)</li>
                        <li>Names should contain only letters, spaces, dots, hyphens, and apostrophes</li>
                        <li>Email must be valid format if provided</li>
                        <li>Date format: YYYY-MM-DD (e.g., 2024-01-15) - optional</li>
                        <li><strong class="text-success">Batch number is automatically assigned</strong> - each upload creates a new batch</li>
                        <li>Maximum file size: 2MB</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadSampleCSV()">
                    <i class="fas fa-download"></i> Download Sample CSV
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable manually - ensure it's only initialized once
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#winners-table') && !$('#winners-table').data('datatable-initialized')) {
        $('#winners-table').data('datatable-initialized', true);
        $('#winners-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.winners.index") }}',
                type: 'GET'
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile_number', name: 'mobile_number'},
                {data: 'batch_no', name: 'batch_no'},
                {data: 'created_date', name: 'created_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[1, 'desc']],
            pageLength: 25,
            responsive: true,
            dom: 'Bfrtip',
            buttons: []
        });
    }
    // CSV Upload Form - prevent multiple submissions
    // Ensure handler is only attached once
    if (!$('#csvUploadForm').data('handler-attached')) {
        $('#csvUploadForm').data('handler-attached', true);
        console.log('Attaching CSV upload handler');
        $('#csvUploadForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevent multiple event handlers
        
        // Validate file selection
        var fileInput = $('#csv_file')[0];
        if (!fileInput.files || fileInput.files.length === 0) {
            showAlert('error', 'Please select a CSV file to upload.');
            return false;
        }
        
        var formData = new FormData(this);
        var uploadBtn = $('#uploadBtn');
        var originalText = uploadBtn.html();
        
        // Prevent multiple submissions
        if (uploadBtn.prop('disabled') || window.csvUploadInProgress) {
            console.log('Form submission blocked - already processing');
            return false;
        }
        
        // Set upload in progress flag
        window.csvUploadInProgress = true;
        
        console.log('Starting CSV upload...');
        uploadBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        
        $.ajax({
            url: '{{ route("admin.winners.upload-csv") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('CSV upload response:', response);
                console.log('Success callback called - csvSuccessShown:', window.csvSuccessShown, 'mainAlert exists:', $('#mainAlert').length);
                if (response.status === 'success') {
                    // Only show alert once - more aggressive prevention
                    if (!$('#mainAlert').length && !window.csvSuccessShown) {
                        window.csvSuccessShown = true;
                        
                        // Create alert directly without using showAlert function
                        var alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="mainAlert">
                                ${response.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `;
                        $('.container-fluid').prepend(alertHtml);
                        
                        // Auto-hide after 5 seconds
                        setTimeout(function() {
                            $('#mainAlert').fadeOut(function() {
                                $(this).remove();
                                window.csvSuccessShown = false;
                            });
                        }, 5000);
                    }
                    $('#csvUploadForm')[0].reset();
                    
                    // Hide file preview
                    $('#filePreviewContainer').addClass('d-none');
                    
                    // Reload DataTable with slight delay
                    setTimeout(function() {
                        if ($.fn.DataTable.isDataTable('#winners-table')) {
                            $('#winners-table').DataTable().ajax.reload();
                        }
                    }, 100);
                } else {
                  //  showAlert('error', response.message);
                    if (response.errors) {
                        console.log('Validation errors:', response.errors);
                    }
                }
            },
            error: function(xhr) {
                console.log('CSV upload error:', xhr);
                var response = xhr.responseJSON;
                showAlert('error', response.message || 'Failed to upload CSV file');
            },
            complete: function() {
                console.log('CSV upload completed');
                uploadBtn.prop('disabled', false).html(originalText);
                window.csvUploadInProgress = false; // Clear upload in progress flag
            }
        });
        }); // Close the if statement
    }
    
    // Delete Winner
    $(document).on('click', '.delete-winner', function() {
        var winnerId = $(this).data('id');
        var winnerName = $(this).data('name') || 'this winner';
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${winnerName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.winners.destroy", ":id") }}'.replace(':id', winnerId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                $('#winners-table').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'Failed to delete winner',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                });
            }
        });
    });
});

// Global showAlert function
window.showAlert = function(type, message) {
    // Remove all existing alerts first
    $('.alert').remove();
    
    // Prevent duplicate alerts with same message within 2 seconds
    var now = Date.now();
    if (window.lastAlertMessage === message && window.lastAlertTime && (now - window.lastAlertTime) < 2000) {
        console.log('Duplicate alert prevented:', message);
        return;
    }
    window.lastAlertMessage = message;
    window.lastAlertTime = now;
    
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" id="mainAlert">
            ${message}
        </div>
    `;
    
    // Insert new alert at the top of the container
    $('.container-fluid').prepend(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('#mainAlert').fadeOut(function() {
            $(this).remove();
            window.lastAlertMessage = null; // Reset after hiding
            window.lastAlertTime = null; // Reset timestamp
        });
    }, 5000);
}

function downloadSampleCSV() {
    // Generate unique mobile numbers using timestamp to avoid duplicates
    var timestamp = Date.now();
    var csvContent = "John Doe,john@example.com," + (6000000000 + (timestamp % 1000000)) + ",2024-01-15\n" +
                     "Jane Smith,jane@example.com," + (7000000000 + ((timestamp + 1) % 1000000)) + ",2024-01-16\n" +
                     "Sarah Wilson,sarah@example.com," + (9000000000 + ((timestamp + 3) % 1000000)) + ",2024-01-18";
    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement("a");
    var url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", "sample_winners.csv");
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endpush
