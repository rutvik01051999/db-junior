<div class="btn-group" role="group">
    <a href="{{ route('admin.junior-editor-registrations.show', $registration->id) }}" 
       class="btn btn-primary btn-sm" 
       data-toggle="tooltip" 
       title="View Details">
        <i class="bx bx-show"></i>
    </a>
    
    @if($registration->payment_status === 'pending')
        <button type="button" 
                class="btn btn-success btn-sm update-payment-status" 
                data-id="{{ $registration->id }}" 
                data-status="completed"
                data-toggle="tooltip" 
                title="Mark as Completed">
            <i class="bx bx-check"></i>
        </button>
    @endif
    
    {{-- @if($registration->payment_status === 'completed')
        <button type="button" 
                class="btn btn-warning btn-sm update-payment-status" 
                data-id="{{ $registration->id }}" 
                data-status="pending"
                data-toggle="tooltip" 
                title="Mark as Pending">
            <i class="bx bx-time"></i>
        </button>
    @endif
    
    @if($registration->payment_status !== 'failed')
        <button type="button" 
                class="btn btn-danger btn-sm update-payment-status" 
                data-id="{{ $registration->id }}" 
                data-status="failed"
                data-toggle="tooltip" 
                title="Mark as Failed">
            <i class="bx bx-x"></i>
        </button>
    @endif --}}
</div>
