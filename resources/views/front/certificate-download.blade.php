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
<section class="contact-area ptb-100 certificate-download-area">
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
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
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
                                        <div id="mobileMessage" class="mt-2"></div>
                                        {{-- <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Please enter the mobile number you used during registration
                                        </small> --}}
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="text-center">
                                        <button type="submit" 
                                                class="default-btn" 
                                                id="verify_otp" style="border: none !important;">
                                            <span class="btn-text">Download Certificate</span>
                                            <span class="btn-icon">
                                                <i class="fas fa-download"></i>
                                            </span>
                                        </button>
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
    <div class="value-shape">
        <div class="shape-1">
            <img src="{{ asset('front/assets/img/value/value-shape-1.png') }}" alt="image">
        </div>
        <div class="shape-2">
            <img src="{{ asset('front/assets/img/value/value-shape-2.png') }}" alt="image">
        </div>
        <div class="shape-3">
            <img src="{{ asset('front/assets/img/value/value-shape-3.png') }}" alt="image">
        </div>
    </div>
</section>
<!-- End Certificate Download Area -->

<!-- OTP Verification Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="justify-content: center;">
        <div class="modal-content" style="width: auto !important;">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Mobile Verification</h4>
            </div>
            <div class="modal-body">
                <p>Enter 6 Digit OTP. We just sent you on <span id='span_mobile'></span> mobile</p>
                <div class='form-row' style='margin-top: 10px;margin-bottom: 10px;display: flex;gap: 4px;'>
                    <div class='form-group col-md-8'>
                        <input type='text' class='form-control' placeholder='Please enter your OTP' id='dialog_otp'
                               maxlength="6" onkeypress="return restrictAlphabets(event)">
                    </div>
                    <div class='form-group col-md-4'>
                        <input type="button" class="default-btn form-control" value="Verify" id='check_otp' onclick="CheckOTP()"/>
                    </div>
                </div>
                <p style="text-align: -webkit-right;">
                    <button type="button" id="resendCode" class="btn btn-link" disabled onclick="ResendCode()">Resend OTP</button>
                    <span id="counter" style="color: blue;"></span>
                </p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Validation Error Styling */
.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.is-valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-control.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-control.is-valid:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Button loading state */
.default-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Success and Error Messages */
#mobileMessage {
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

#mobileMessage.success {
    color: #28a745;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 0.25rem;
    padding: 0.5rem;
}

#mobileMessage.error {
    color: #dc3545;
    /* background-color: #f8d7da; */
    /* border: 1px solid #f5c6cb; */
    /* border-radius: 0.25rem;
    padding: 0.5rem; */
}

#mobileMessage.info {
    color: #0c5460;
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    border-radius: 0.25rem;
    padding: 0.5rem;
}
</style>
@endpush

@push('scripts')
<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<script>
// Restrict input to numbers only
function restrictAlphabets(e) {
    var x = e.which || e.keycode;
    if ((x >= 48 && x <= 57) || x == 8 || (x >= 35 && x <= 40) || x == 46)
        return true;
    else
        return false;
}

// Initialize jQuery Validation
$(document).ready(function() {
    // Custom validation methods
    $.validator.addMethod("mobileNumber", function(value, element) {
        return this.optional(element) || /^[6-9]\d{9}$/.test(value);
    }, "Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9");

    // Form validation rules
    $("#certificateForm").validate({
        rules: {
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
                mobileNumber: true
            }
        },
        messages: {
            mobile: {
                required: "Please enter your mobile number",
                minlength: "Mobile number must be exactly 10 digits",
                maxlength: "Mobile number must be exactly 10 digits",
                mobileNumber: "Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9"
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            // This will be called when form is valid
            VerifyMobile();
            return false; // Prevent default form submission
        }
    });

    // Real-time validation on input
    $('#mobileno').on('input', function() {
        $(this).valid();
        // Hide any existing messages when user starts typing
        hideMessage();
    });
});

// Function to show message below input field
function showMessage(message, type) {
    var messageDiv = document.getElementById('mobileMessage');
    messageDiv.className = type;
    messageDiv.innerHTML = message;
    messageDiv.style.display = 'block';
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(function() {
            messageDiv.style.display = 'none';
        }, 5000);
    }
}

// Function to hide message
function hideMessage() {
    var messageDiv = document.getElementById('mobileMessage');
    messageDiv.style.display = 'none';
    messageDiv.className = '';
    messageDiv.innerHTML = '';
}

// Global variables for OTP verification
var mobile_verified = false;
var otp_value = '';

// Verify mobile number and send OTP
function VerifyMobile() {
    var mobile = document.getElementById('mobileno').value;
    var button = document.getElementById('verify_otp');
    
    // Hide any previous messages
    hideMessage();
    
    // Validate mobile number
    if (mobile == '') {
        document.getElementById('mobileno').style.borderColor = 'red';
        showMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter mobile number', 'error');
        document.getElementById('mobileno').focus();
        return;
    } else {
        if (mobile.length == 10) {
            document.getElementById('mobileno').style.borderColor = '';
            ResendCode();
        } else {
            document.getElementById('mobileno').style.borderColor = 'red';
            showMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter a valid 10-digit mobile number', 'error');
            document.getElementById('mobileno').focus();
        }
    }
}

// Send OTP to mobile number
function ResendCode() {
    var mobile = document.getElementById('mobileno').value;
    
    $.ajax({
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            mobile: mobile
        },
        url: '{{ route("certificate.download") }}',
        success: function(response) {
            if (response.status === 1) {
                // Show OTP modal
                $('#otpModal').modal('show');
                $('#span_mobile').html(mobile);
                otp_value = response.data;
                $('#resendCode').attr('disabled', true);
                
                // Start countdown timer
                var sec = 60;
                var countDiv = document.getElementById("counter");
                var countDown = setInterval(function() {
                    secpass();
                }, 1000);

                function secpass() {
                    var min = Math.floor(sec / 60);
                    var remSec = sec % 60;
                    if (remSec < 10) {
                        remSec = '0' + remSec;
                    }
                    if (min < 10) {
                        min = '0' + min;
                    }
                    countDiv.innerHTML = min + ":" + remSec;
                    if (sec > 0) {
                        sec = sec - 1;
                    } else {
                        clearInterval(countDown);
                        countDiv.innerHTML = '00:00';
                    }
                    if (countDiv.innerHTML === '00:00') {
                        $('#resendCode').attr('disabled', false);
                    }
                }
            } else {
                showMessage('<i class="fas fa-exclamation-circle me-2"></i>' + response.message, 'error');
                document.getElementById('mobileno').focus();
            }
        },
        error: function(xhr) {
            var errorMessage = 'An error occurred. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showMessage('<i class="fas fa-exclamation-triangle me-2"></i>' + errorMessage, 'error');
        }
    });
}

// Verify OTP
function CheckOTP() {
    var entered_otp = $('#dialog_otp').val();
    
    if (entered_otp == '') {
        $('#dialog_otp').css('border-color', 'red');
        $('#dialog_otp').focus();
        showMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter OTP', 'error');
    } else {
        if (entered_otp.length == 6) {
            if (otp_value == entered_otp) {
                $('#mobileno').attr('disabled', true);
                $('#verify_otp').attr('disabled', true);
                $('#verify_otp').css('background', 'green');
                $('#verify_otp').html('<span class="btn-text">Mobile Verified</span>');
                $('#otpModal').modal('hide');
                mobile_verified = true;
                
                // Show success message and download certificate
                showMessage('<i class="fas fa-check-circle me-2"></i>Mobile verified successfully! Downloading your certificate...', 'success');
                GetCertificate($('#mobileno').val());
            } else {
                showMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter valid OTP', 'error');
            }
        } else {
            $('#dialog_otp').css('border-color', 'red');
            $('#dialog_otp').focus();
            showMessage('<i class="fas fa-exclamation-circle me-2"></i>Please enter valid 6 digits OTP', 'error');
        }
    }
}

// Download certificate
function GetCertificate(mobile) {
    // Use fetch API for better download handling
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('mobile', mobile);
    
    fetch('{{ route("certificate.download-jpg") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'Certificate_' + mobile + '_' + new Date().toISOString().split('T')[0] + '.jpg';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        console.error('Download error:', error);
        showMessage('<i class="fas fa-exclamation-circle me-2"></i>Error downloading certificate. Please try again.', 'error');
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
