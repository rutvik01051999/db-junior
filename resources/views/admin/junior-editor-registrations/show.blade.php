@extends('admin.layouts.app')

@section('title', 'Registration Details')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Registration Details',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Junior Editor Registrations' => route('admin.junior-editor-registrations.index'),
            'Details' => '#',
        ],
    ])

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Registration Information
                    </div>
                    <div class="btn-canvas">
                        <a href="{{ route('admin.junior-editor-registrations.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bx bx-arrow-back"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Student Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Student Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Registration ID:</strong></td>
                                    <td>{{ $juniorEditorRegistration->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Student Name:</strong></td>
                                    <td>{{ $juniorEditorRegistration->first_name }} {{ $juniorEditorRegistration->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Parent Name:</strong></td>
                                    <td>{{ $juniorEditorRegistration->parent_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Mobile Number:</strong></td>
                                    <td>{{ $juniorEditorRegistration->mobile_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $juniorEditorRegistration->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Birth:</strong></td>
                                    <td>{{ $juniorEditorRegistration->birth_date ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Gender:</strong></td>
                                    <td>{{ ucfirst($juniorEditorRegistration->gender ?? 'N/A') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- School Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">School Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>School Name:</strong></td>
                                    <td>{{ $juniorEditorRegistration->school_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Class:</strong></td>
                                    <td>{{ $juniorEditorRegistration->school_class ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>School Telephone:</strong></td>
                                    <td>{{ $juniorEditorRegistration->school_telephone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>School Address:</strong></td>
                                    <td>{{ $juniorEditorRegistration->school_address ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <!-- Address Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Address Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td>{{ $juniorEditorRegistration->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>State:</strong></td>
                                    <td>{{ $juniorEditorRegistration->state ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>City:</strong></td>
                                    <td>{{ $juniorEditorRegistration->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pincode:</strong></td>
                                    <td>{{ $juniorEditorRegistration->pincode ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Payment Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Payment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Amount:</strong></td>
                                    <td>₹{{ number_format($juniorEditorRegistration->amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        @php
                                            $status = $juniorEditorRegistration->payment_status;
                                            $badgeClass = $status === 'completed' ? 'success' : ($status === 'failed' ? 'danger' : 'warning');
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Razorpay Order ID:</strong></td>
                                    <td>{{ $juniorEditorRegistration->razorpay_order_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Razorpay Payment ID:</strong></td>
                                    <td>{{ $juniorEditorRegistration->razorpay_payment_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Delivery Type:</strong></td>
                                    <td>{{ $juniorEditorRegistration->delivery_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pickup Center:</strong></td>
                                    <td>{{ $juniorEditorRegistration->pickup_centers ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <!-- System Information -->
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3">System Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Registration Date:</strong></td>
                                    <td>{{ $juniorEditorRegistration->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $juniorEditorRegistration->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Mobile Verified:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $juniorEditorRegistration->mobile_verified ? 'success' : 'danger' }}">
                                            {{ $juniorEditorRegistration->mobile_verified ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Source:</strong></td>
                                    <td>{{ $juniorEditorRegistration->from_source ?? 'Direct' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Status Update -->
                    {{-- <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3">Update Payment Status</h5>
                            <div class="btn-group" role="group">
                                @if($juniorEditorRegistration->payment_status !== 'completed')
                                    <button type="button" 
                                            class="btn btn-success update-payment-status" 
                                            data-id="{{ $juniorEditorRegistration->id }}" 
                                            data-status="completed">
                                        <i class="bx bx-check"></i> Mark as Completed
                                    </button>
                                @endif
                                
                                @if($juniorEditorRegistration->payment_status !== 'pending')
                                    <button type="button" 
                                            class="btn btn-warning update-payment-status" 
                                            data-id="{{ $juniorEditorRegistration->id }}" 
                                            data-status="pending">
                                        <i class="bx bx-time"></i> Mark as Pending
                                    </button>
                                @endif
                                
                                @if($juniorEditorRegistration->payment_status !== 'failed')
                                    <button type="button" 
                                            class="btn btn-danger update-payment-status" 
                                            data-id="{{ $juniorEditorRegistration->id }}" 
                                            data-status="failed">
                                        <i class="bx bx-x"></i> Mark as Failed
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle payment status update
        $('.update-payment-status').click(function() {
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
                                // Reload the page to show updated status
                                location.reload();
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
