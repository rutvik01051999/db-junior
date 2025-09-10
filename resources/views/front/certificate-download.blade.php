@extends('front.layouts.app')

<!-- Start Page Banner -->
{{-- <div class="page-banner-area">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-banner-content">
                    <h2>Certificate Download</h2>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li>Certificate Download</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End Page Banner -->

<!-- Start Certificate Download Area -->
<section class="contact-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-certificate me-2"></i>
                            Certificate Download
                        </h3>
                        <p class="mb-0 mt-2">Enter your registered mobile number to download your certificate</p>
                    </div>
                    <div class="card-body p-4">
                        <form id="certificateForm">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="mobileno" class="form-label fw-bold">
                                            <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                            Mobile Number
                                        </label>
                                        <input type="text" 
                                               id="mobileno" 
                                               name="mobile" 
                                               class="form-control form-control-lg" 
                                               placeholder="Enter your 10-digit mobile number" 
                                               maxlength="10"
                                               onkeypress="return restrictAlphabets(event)"
                                               required>
                                        <div class="help-block with-errors"></div>
                                        {{-- <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Please enter the mobile number you used during registration
                                        </small> --}}
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="text-center">
                                        <a type="button" 
                                                class="default-btn disabled" 
                                                id="verify_otp"
                                                onclick="VerifyMobile()" 
                                                style="pointer-events: all; cursor: pointer;">
                                            <span class="btn-text">Download Certificate</span>
                                            <span class="btn-icon">
                                                <i class="fas fa-download"></i>
                                            </span>
                                        </a>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your information is secure and will not be shared with third parties
                        </small>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Certificate Download Area -->

@push('scripts')
<script>
// Restrict input to numbers only
function restrictAlphabets(e) {
    var x = e.which || e.keycode;
    if ((x >= 48 && x <= 57))
        return true;
    else
        return false;
}

// Verify mobile number and download certificate
function VerifyMobile() {
    var mobile = document.getElementById('mobileno').value;
    var button = document.getElementById('verify_otp');
    
    // Validate mobile number
    if (mobile.length !== 10) {
        alert('Please enter a valid 10-digit mobile number.');
        return;
    }
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<span class="btn-text">Verifying...</span><span class="btn-icon"><i class="fas fa-spinner fa-spin"></i></span>';
    
    // Send AJAX request
    $.ajax({
        url: '{{ route("certificate.download") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            mobile: mobile
        },
        success: function(response) {
            if (response.status === 1) {
                // Success - show OTP message
                alert('OTP sent to your mobile number: ' + response.data);
                // You can add OTP verification logic here if needed
            } else {
                // Error - show error message
                alert(response.message);
            }
        },
        error: function(xhr) {
            // Handle AJAX errors
            alert('An error occurred. Please try again.');
        },
        complete: function() {
            // Reset button state
            button.disabled = false;
            button.innerHTML = '<span class="btn-text">Download Certificate</span><span class="btn-icon"><i class="fas fa-download"></i></span>';
        }
    });
}

// Add jQuery if not already loaded
if (typeof $ === 'undefined') {
    var script = document.createElement('script');
    script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
    document.head.appendChild(script);
}
</script>
@endpush
