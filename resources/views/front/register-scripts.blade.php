@push('scripts')
<!-- Include required libraries -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<script>

console.log('Register scripts loaded');
// Global variables
var mobile_verified = false;
var otpData = null;

// Initialize page
$(document).ready(function() {
    console.log('Register scripts loaded');
    
    // Initialize date picker with simple HTML5 date input
    $('#birthdate').attr('type', 'date');
    
    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    $('#birthdate').attr('max', today);
    
    // Set min date to 2000
    $('#birthdate').attr('min', '2000-01-01');
    
    // Load states
    fetchAllState();
    
    // Initialize jQuery Validation
    initializeFormValidation();
    
    // Delivery type change handler
    $('#delivery_type').on('change', function() {
        handleDeliveryTypeChange();
        // Re-validate pickup centers when delivery type changes
        $('#pickup_centers').valid();
    });
    
    // Pickup centers change handler
    $('#pickup_centers').on('change', function() {
        handlePickupCenterChange();
    });
    
    // OTP verification handler
    $('#check_otp').on('click', function() {
        verifyOtp();
    });
    
    // Real-time validation for mobile number
    $('#mobileno').on('blur', function() {
        if ($(this).val().length === 10 && /^[6-9]\d{9}$/.test($(this).val())) {
            $(this).valid();
        }
    });
    
    // Real-time validation for email
    $('#email').on('blur', function() {
        if ($(this).val()) {
            $(this).valid();
        }
    });
    
    // Real-time validation for pincode
    $('#pincode').on('blur', function() {
        if ($(this).val().length === 6 && /^[1-9][0-9]{5}$/.test($(this).val())) {
            $(this).valid();
        }
    });
    
    // Auto-save partial registration data
    let saveTimeout;
    $('input, select, textarea').on('change blur', function() {
        if (mobile_verified) {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(function() {
                savePartialRegistration();
            }, 2000); // Save after 2 seconds of inactivity
        }
    });
    
    // Dropdowns will work normally without search functionality
    
    // Global form submit handler for debugging
    $('#orderForm').on('submit', function(e) {
        console.log('Form submit event triggered');
        console.log('Event type:', e.type);
        console.log('Default prevented:', e.isDefaultPrevented());
        console.log('Form data:', $(this).serialize());
        
        // Check if form is valid
        const isValid = $(this).valid();
        console.log('Form is valid:', isValid);
        
        if (!isValid) {
            console.log('Form validation failed, preventing submission');
            e.preventDefault();
            return false;
        }
    });
    
    // Test form validation manually
    setTimeout(function() {
        console.log('Testing form validation...');
        const form = $('#orderForm');
        const isValid = form.valid();
        console.log('Form validation test result:', isValid);
        
        if (form.length > 0) {
            console.log('Form found, validation plugin attached:', form.data('validator') !== undefined);
        } else {
            console.log('Form not found!');
        }
    }, 2000);
});

// Initialize jQuery Validation
function initializeFormValidation() {
    // Add custom validation methods
    $.validator.addMethod("mobileNumber", function(value, element) {
        return this.optional(element) || /^[6-9]\d{9}$/.test(value);
    }, "Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9");

    $.validator.addMethod("pincode", function(value, element) {
        return this.optional(element) || /^[1-9][0-9]{5}$/.test(value);
    }, "Please enter a valid 6-digit pincode");

    $.validator.addMethod("nameOnly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter only letters and spaces");

    $.validator.addMethod("mobileVerified", function(value, element) {
        console.log('Mobile verification check - mobile_verified:', mobile_verified);
        return mobile_verified;
    }, "Please verify your mobile number first");

    $.validator.addMethod("validAge", function(value, element) {
        if (!value) return false;
        const birthDate = new Date(value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        return age >= 4 && age <= 18;
    }, "Age must be between 4 and 18 years");

    // Initialize validation
    console.log('Initializing jQuery validation...');
    $("#orderForm").validate({
        rules: {
            parent_name: {
                required: false,
                nameOnly: true,
                minlength: 2,
                maxlength: 50
            },
            mobileno: {
                required: true,
                mobileNumber: true,
                mobileVerified: true
            },
            first_name: {
                required: false,
                nameOnly: true,
                minlength: 2,
                maxlength: 30
            },
            last_name: {
                required: false,
                nameOnly: true,
                minlength: 2,
                maxlength: 30
            },
            email: {
                required: false,
                email: true,
                maxlength: 100
            },
            birthdate: {
                required: false,
                validAge: true
            },
            gender: {
                required: false
            },
            address: {
                required: false,
                minlength: 10,
                maxlength: 200
            },
            pincode: {
                required: false,
                pincode: true
            },
            state: {
                required: false
            },
            city: {
                required: false
            },
            school_name: {
                required: false,
                minlength: 2,
                maxlength: 100
            },
            school_class: {
                required: false
            },
            school_address: {
                required: false,
                minlength: 10,
                maxlength: 200
            },
            delivery_type: {
                required: false
            },
            pickup_centers: {
                required: function() {
                    return $("#delivery_type").val() === 'Self Pick Up';
                }
            }
        },
        messages: {
            parent_name: {
                required: "Please enter Father's/Mother's name",
                nameOnly: "Name should contain only letters and spaces",
                minlength: "Name must be at least 2 characters long",
                maxlength: "Name cannot exceed 50 characters"
            },
            mobileno: {
                required: "Please enter mobile number",
                mobileNumber: "Please enter a valid 10-digit mobile number",
                mobileVerified: "Please verify your mobile number first"
            },
            first_name: {
                required: "Please enter first name",
                nameOnly: "First name should contain only letters and spaces",
                minlength: "First name must be at least 2 characters long",
                maxlength: "First name cannot exceed 30 characters"
            },
            last_name: {
                required: "Please enter last name",
                nameOnly: "Last name should contain only letters and spaces",
                minlength: "Last name must be at least 2 characters long",
                maxlength: "Last name cannot exceed 30 characters"
            },
            email: {
                required: "Please enter email address",
                email: "Please enter a valid email address",
                maxlength: "Email cannot exceed 100 characters"
            },
            birthdate: {
                required: "Please select birthdate",
                validAge: "Age must be between 4 and 18 years"
            },
            gender: {
                required: "Please select gender"
            },
            address: {
                required: "Please enter address",
                minlength: "Address must be at least 10 characters long",
                maxlength: "Address cannot exceed 200 characters"
            },
            pincode: {
                required: "Please enter pincode",
                pincode: "Please enter a valid 6-digit pincode"
            },
            state: {
                required: "Please select state"
            },
            city: {
                required: "Please select city"
            },
            school_name: {
                required: "Please enter school name",
                minlength: "School name must be at least 2 characters long",
                maxlength: "School name cannot exceed 100 characters"
            },
            school_class: {
                required: "Please select class"
            },
            school_address: {
                required: "Please enter school address",
                minlength: "School address must be at least 10 characters long",
                maxlength: "School address cannot exceed 200 characters"
            },
            delivery_type: {
                required: "Please select delivery type"
            },
            pickup_centers: {
                required: "Please select pickup center"
            }
        },
        errorElement: "div",
        errorClass: "validation-error",
        errorPlacement: function(error, element) {
            // For radio buttons, place error after the radio group
            if (element.attr("type") === "radio") {
                error.insertAfter(element.closest(".form-group"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("error").removeClass("valid");
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("error").addClass("valid");
            $(element).closest('.form-group').removeClass('has-error');
        },
        submitHandler: function(form) {
            console.log('Form submit handler called - form is valid');
            // This will be called when form is valid
            // Add loading state to submit button
            const submitBtn = $('button[type="submit"]');
            submitBtn.addClass('btn-loading').prop('disabled', true);
            
            console.log('Calling Checkoutpayment...');
            Checkoutpayment();
            console.log('Preventing default form submission');
            return false; // Prevent default form submission
        },
        invalidHandler: function(event, validator) {
            console.log('Form validation failed');
            console.log('Number of invalid fields:', validator.numberOfInvalids());
            console.log('Invalid fields:', validator.invalid);
        }
    });
}

// Dropdowns work normally - no custom search functionality needed

// Handle delivery type change
function handleDeliveryTypeChange() {
    const deliveryType = $('#delivery_type').val();
    console.log('Delivery type changed to:', deliveryType);
    
    if (deliveryType === 'Door Step Delivery') {
        $("#div_note").show();
        $("#div_note1").hide();
        $("#div_tag").hide();
        $("#div_tag_day").hide();
        $('#amount').val('1');
        $('#amount1').val('₹ 1');
        console.log('Amount set to ₹1');
    } else if (deliveryType === 'Self Pick Up') {
        $("#div_note").hide();
        $("#div_note1").show();
        $("#div_tag").show();
        $("#div_tag_day").show();
        $('#amount').val('100');
        $('#amount1').val('₹ 100');
        console.log('Amount set to ₹100');
    } else {
        $("#div_note").hide();
        $("#div_note1").hide();
        $("#div_tag").hide();
        $("#div_tag_day").hide();
        $('#amount').val('0');
        $('#amount1').val('₹ 0');
        console.log('Amount set to ₹0');
    }
}

// Handle pickup center change
function handlePickupCenterChange() {
    const center = $('#pickup_centers').val();
    const addresses = {
        'BHOPAL': 'Dainik Bhaskar Office, Dwarka Sadan, 6, Press Complex, M.P. Nagar, Zone-1, Bhopal, Madhya Pradesh. 462011',
        'AURANGABAD': 'Divya Marathi Office, Plot No. 15295, Motiwala, Complex, Jalna Road, Opp. Air India Office, Aurangabad – 431003',
        'AHEMADABAD': 'Divya Bhaskar Office, 280, "Bhaskar House", Near YMCA Club, Makarba, S G Highway, Ahmedabad – 380051',
        'CHANDIGARH': 'Dainik Bhaskar Office, Plot No. 11-12, Sector-25/D, Chandigarh - 160014',
        'INDORE': 'Dainik Bhaskar Office, 4/54, Press Complex, A.B. Road, Indore (M.P.), 452010',
        'JAIPUR': 'Dainik Bhaskar Office, 10, J.L.N. Marg, Jaipur – 302015, Rajasthan',
        'PATNA': 'Dainik Bhaskar Office, 4th floor, Asha Arcade, above Asha Hero, Near Beur More, Anishabad, Patna - 800002',
        'RANCHI': 'Dainik Bhaskar Office, 6th floor, H. No. 601,602, Panchwati Tower, Behind Vishal Mega Mart, Harmu Road, Ranchi - 834001',
        'PANIPAT': 'Dainik Bhaskar Office, Plot 42-43, Sector 29, Phase II, Industrial Area, Panipat, Haryana - 132103',
        'RAIPUR': 'Dainik Bhaskar Office, Plot No.1, Block No.9, DB City Corporate Park, Rajbandha Maidan, Chhattisgarh 492001',
        'JALANDHAR': 'Dainik Bhaskar, SEO-16, Ladowali Rd, PUDA Complex, Rajinder Nagar, Jalandhar, Punjab - 144002',
        'LUDHIANA': 'Dainik Bhaskar Office , 519 D Building, Adjoining MBD Mall, Ferozepur Rd,  Ludhiana, Punjab 141012',
        'AMRITSAR': 'Dainik Bhaskar , Plot No 35, 36, Block - D, Ranjit Avenue, Amritsar, Punjab, 143001'
    };
    
    $('#office_address').val(addresses[center] || 'No Select Pickup Center');
}

// Send OTP
function VerifyMobile() {
    const mobile = $("#mobileno").val();
    console.log('VerifyMobile called with:', mobile);
    
    if (!mobile) {
        $("#mobileno").css("border-color", "red");
        notify('danger', 'Please enter mobile number');
        $("#mobileno").focus();
        return;
    }
    
    if (mobile.length !== 10) {
        $("#mobileno").css("border-color", "red");
        notify('danger', 'Please enter valid 10-digit mobile number');
        $("#mobileno").focus();
        return;
    }
    
    $("#mobileno").css("border-color", "");
    ResendCode();
}

// Resend OTP
function ResendCode() {
    const mobile = $("#mobileno").val();
    console.log('ResendCode called for mobile:', mobile);
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.send-otp") }}',
        data: {
            mobile: mobile,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('OTP response:', response);
            if (response.status === '1') {
                $('#centermodal').modal('show');
                $("#span_mobile").html(mobile);
                otpData = response.data; // Store OTP for verification
                
                // Start countdown
                //startCountdown();
                notify('success', 'OTP sent successfully');
            } else {
                notify('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('OTP error:', error);
            notify('danger', 'Failed to send OTP. Please try again.');
        }
    });
}

// Verify OTP
function verifyOtp() {
    const otp = $("#dialog_otp").val();
    const mobile = $("#mobileno").val();
    console.log('verifyOtp called with OTP:', otp, 'Mobile:', mobile);
    
    if (!otp) {
        $("#dialog_otp").css("border-color", "red");
        notify('danger', 'Please enter OTP');
        $("#dialog_otp").focus();
        return;
    }
    
    if (otp.length !== 6) {
        $("#dialog_otp").css("border-color", "red");
        notify('danger', 'Please enter valid 6-digit OTP');
        $("#dialog_otp").focus();
        return;
    }
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.verify-otp") }}',
        data: {
            mobile: mobile,
            otp: otp,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('OTP verification response:', response);
            if (response.status === '1') {
                $("#mobileno").attr("disabled", true);
                $("#verify_otp").attr("disabled", true);
                $("#verify_otp").css("background", "green");
                $("#verify_otp").val("Verified");
                $('#centermodal').modal('hide');
                mobile_verified = true;
                
                // Add verified class and trigger validation
                $("#mobileno").addClass("mobile-verified");
                $("#mobileno").valid(); // Re-validate the field
                
                console.log('Mobile verification completed - mobile_verified set to true');
                notify('success', 'Mobile number verified successfully');
            } else {
                notify('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('OTP verification error:', error);
            notify('danger', 'OTP verification failed. Please try again.');
        }
    });
}

// Start countdown timer
function startCountdown() {
    let sec = 60;
    const countDiv = document.getElementById("counter");
    const resendBtn = document.getElementById("resendCode");
    
    resendBtn.disabled = true;
    
    const countDown = setInterval(function() {
        const min = Math.floor(sec / 60);
        let remSec = sec % 60;
        
        if (remSec < 10) remSec = '0' + remSec;
        if (min < 10) min = '0' + min;
        
        countDiv.innerHTML = min + ":" + remSec;
        
        if (sec > 0) {
            sec = sec - 1;
        } else {
            clearInterval(countDown);
            countDiv.innerHTML = '00:00';
            resendBtn.disabled = false;
        }
    }, 1000);
}

// Fetch all states
function fetchAllState() {
    console.log('Fetching states...');
    $.ajax({
        type: 'GET',
        url: '{{ route("junior-editor.states") }}',
        success: function(response) {
            console.log('States response:', response);
            if (response.status === 'success') {
                let options = "<option value=''>Select State</option>";
                $.each(response.data, function(index, val) {
                    options += "<option value='" + val.name + "'>" + val.name + "</option>";
                });
                $('#state').html(options);
                fetchAllCity();
            }
        },
        error: function(xhr, status, error) {
            console.error('States error:', error);
            $('#state').html("<option value=''>No State Available</option>");
        }
    });
}

// Fetch cities by state
function fetchAllCity() {
    $('#state').on('change', function() {
        const state = $(this).val();
        console.log('State changed to:', state);
        
        if (!state) {
            $('#city').html("<option value=''>Select City</option>");
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
                console.log('Cities response:', response);
                if (response.status === 'success') {
                    let options = "<option value=''>Select City</option>";
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
}

// Save partial registration data
function savePartialRegistration() {
    if (!mobile_verified) {
        return; // Don't save if mobile is not verified
    }
    
    const formData = {
        parent_name: $("#parent_name").val(),
        first_name: $("#first_name").val(),
        last_name: $("#last_name").val(),
        email: $("#email").val(),
        mobile: $("#mobileno").val(),
        birth_date: $("#birthdate").val(),
        gender: $("input[type=radio][name=gender]:checked").val(),
        address: $("#address").val(),
        pincode: $("#pincode").val(),
        state: $("#state").val(),
        city: $("#city").val(),
        school_name: $("#school_name").val(),
        school_telephone: $("#school_telephone_no").val(),
        school_class: $("#school_class").val(),
        school_address: $("#school_address").val(),
        delivery_type: $("#delivery_type").val(),
        amount: $("#amount").val(),
        pickup_centers: $("#pickup_centers").val(),
        from: 'direct',
        _token: '{{ csrf_token() }}'
    };
    
    console.log('Saving partial registration data...');
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.save-partial") }}',
        data: formData,
        success: function(response) {
            console.log('Partial registration saved:', response);
        },
        error: function(xhr, status, error) {
            console.error('Failed to save partial registration:', error);
        }
    });
}

// Form validation and checkout
function Checkoutpayment() {
    console.log('Checkoutpayment called');
    console.log('Mobile verified status:', mobile_verified);
    
    // jQuery validation will handle all validation automatically
    // This function is called only when form is valid
    console.log('Calling createOrder...');
    createOrder();
}

// Create Razorpay order
function createOrder() {
    console.log('createOrder called');
    console.log('Form data being prepared...');
    const formData = {
        parent_name: $("#parent_name").val(),
        first_name: $("#first_name").val(),
        last_name: $("#last_name").val(),
        email: $("#email").val(),
        mobile: $("#mobileno").val(),
        birth_date: $("#birthdate").val(),
        gender: $("input[type=radio][name=gender]:checked").val(),
        address: $("#address").val(),
        pincode: $("#pincode").val(),
        state: $("#state").val(),
        city: $("#city").val(),
        school_name: $("#school_name").val(),
        school_telephone: $("#school_telephone_no").val(),
        school_class: $("#school_class").val(),
        school_address: $("#school_address").val(),
        delivery_type: $("#delivery_type").val(),
        amount: $("#amount").val(),
        pickup_centers: $("#pickup_centers").val(),
        from: 'direct',
        _token: '{{ csrf_token() }}'
    };
    
    console.log('Form data:', formData);
    console.log('Making AJAX request to: {{ route("junior-editor.create-order") }}');
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.create-order") }}',
        data: formData,
        beforeSend: function() {
            console.log('AJAX request starting...');
        },
        success: function(response) {
            console.log('Order creation response:', response);
            if (response.status === '1') {
                console.log('Order created successfully, opening Razorpay...');
                openRazorpayCheckout(response.data);
            } else {
                notify('danger', response.message);
            }
            
            // Reset submit button state
            const submitBtn = $('input[type="button"][onclick="Checkoutpayment();"]');
            submitBtn.removeClass('btn-loading').prop('disabled', false);
        },
        error: function(xhr, status, error) {
            console.error('Order creation error:', error);
            console.error('XHR status:', xhr.status);
            console.error('XHR response:', xhr.responseText);
            console.error('Status:', status);
            notify('danger', 'Failed to create order. Please try again.');
            
            // Reset submit button state
            const submitBtn = $('button[type="submit"]');
            submitBtn.removeClass('btn-loading').prop('disabled', false);
        }
    });
}

// Open Razorpay checkout
function openRazorpayCheckout(orderData) {
    console.log('Opening Razorpay checkout with data:', orderData);
    
    var options = {
        "key": "rzp_live_U6SQkI1OHSjZ2n", // Enter the Key ID generated from the Dashboard
        "amount": orderData.amount, // Amount is in currency subunits
        "currency": "INR",
        "name": "DB Corp",
        "description": orderData.receipt,
        "image": "https://junioreditor.groupbhaskar.in/images/JE6-WebSlice_01.gif",
        "order_id": orderData.order_id, // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        "handler": function (response) {
            console.log('Payment successful:', response);
            updatePaymentStatus(response, orderData.mobile);
        },
        "prefill": {
            "name": $("#parent_name").val(),
            "email": $("#email").val(),
            "contact": orderData.mobile
        },
        "notes": {
            "address": "Db Corp Office"
        },
        "theme": {
            "color": "#ea512e"
        },
        "modal": {
            "ondismiss": function() {
                console.log('Payment modal dismissed');
                notify('info', 'Payment cancelled');
            }
        }
    };
    
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function (response) {
        console.log('Payment failed:', response.error);
        handlePaymentFailure(response.error, orderData.order_id);
    });
    
    rzp1.open();
}

// Update payment status after successful payment
function updatePaymentStatus(response, mobile) {
    console.log('Updating payment status...');
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.update-payment") }}',
        data: {
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            mobile: mobile,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Payment status updated:', response);
            if (response.status === '1') {
                notify('success', 'Payment successful! You will receive a confirmation email shortly.');
                // Redirect to success page or show success message
                setTimeout(function() {
                    window.location.href = '/payment-success?payment_id=' + response.data.payment_id;
                }, 2000);
            } else {
                notify('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to update payment status:', error);
            notify('danger', 'Payment successful but failed to update status. Please contact support.');
        }
    });
}

// Handle payment failure
function handlePaymentFailure(error, orderId) {
    console.log('Handling payment failure:', error);
    
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.payment-failure") }}',
        data: {
            razorpay_order_id: orderId,
            mobile: $("#mobileno").val(),
            error_code: error.code,
            error_description: error.description,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Payment failure recorded:', response);
            notify('danger', 'Payment failed: ' + error.description);
        },
        error: function(xhr, status, error) {
            console.error('Failed to record payment failure:', error);
            notify('danger', 'Payment failed. Please try again.');
        }
    });
    
    // Reset submit button state
    const submitBtn = $('button[type="submit"]');
    submitBtn.removeClass('btn-loading').prop('disabled', false);
}

// Update transaction
function updateTransaction(response, mobile) {
    console.log('updateTransaction called');
    $.ajax({
        type: 'POST',
        url: '{{ route("junior-editor.update-payment") }}',
        data: {
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            mobile: mobile,
            name: $("#parent_name").val(),
            email: $("#email").val(),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Payment update response:', response);
            if (response.status === '1') {
                // Show success message
                $("#successMessage").show();
                $("#orderForm").hide();
                notify('success', 'Payment completed successfully!');
                
                // Redirect to success page or show receipt
                setTimeout(function() {
                    window.location.href = '/payment-success?payment_id=' + response.razorpay_payment_id;
                }, 2000);
            } else {
                notify('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Payment update error:', error);
            notify('danger', 'Failed to update payment. Please contact support.');
        }
    });
}

// Utility functions
function restrictAlphabets(e) {
    const x = e.which || e.keycode;
    if ((x >= 48 && x <= 57) || x == 8 || (x >= 35 && x <= 40) || x == 46) {
        return true;
    } else {
        return false;
    }
}

function notify(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'danger' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="bx bx-${type === 'success' ? 'check-circle' : type === 'danger' ? 'x-circle' : 'info-circle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Insert new alert
    $('.contact-form').prepend(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
@endpush
