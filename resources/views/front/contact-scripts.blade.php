@push('scripts')
<!-- Include jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Contact form validation loaded');
    
    // Initialize jQuery Validation
    $("#contactForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            },
            phone_number: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            message: {
                required: true,
                minlength: 10,
                maxlength: 1000
            }
        },
        messages: {
            name: {
                required: "{{ __('contact.validation.name_required') }}",
                minlength: "{{ __('contact.validation.name_min') }}",
                maxlength: "{{ __('contact.validation.name_max') }}"
            },
            email: {
                required: "{{ __('contact.validation.email_required') }}",
                email: "{{ __('contact.validation.email_invalid') }}",
                maxlength: "{{ __('contact.validation.email_max') }}"
            },
            phone_number: {
                required: "{{ __('contact.validation.phone_required') }}",
                digits: "{{ __('contact.validation.phone_digits') }}",
                minlength: "{{ __('contact.validation.phone_min') }}",
                maxlength: "{{ __('contact.validation.phone_max') }}"
            },
            message: {
                required: "{{ __('contact.validation.message_required') }}",
                minlength: "{{ __('contact.validation.message_min') }}",
                maxlength: "{{ __('contact.validation.message_max') }}"
            }
        },
        errorElement: 'div',
        errorClass: 'validation-error',
        errorPlacement: function(error, element) {
            // Remove existing error messages
            element.siblings('.help-block').remove();
            
            // Add error message after the input
            error.addClass('help-block with-errors');
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('error').removeClass('valid');
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('error').addClass('valid');
            $(element).closest('.form-group').removeClass('has-error');
        },
        submitHandler: function(form) {
            // Show loading state
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            submitBtn.prop('disabled', true).addClass('btn-loading');
            submitBtn.text('{{ __("contact.form.submitting") }}');
            
            // Submit the form
            form.submit();
        }
    });
    
    // Real-time validation on blur
    $('#name, #email, #phone_number, #message').on('blur', function() {
        $(this).valid();
    });
    
    // Phone number formatting
    $('#phone_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
        $(this).val(value);
    });
    
    // Character counter for message
    $('#message').on('input', function() {
        const maxLength = 1000;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        // Remove existing counter
        $(this).siblings('.char-counter').remove();
        
        // Add character counter
        if (currentLength > 0) {
            const counterClass = remaining < 50 ? 'text-warning' : 'text-muted';
            $(this).after(`<small class="char-counter ${counterClass}">${remaining} characters remaining</small>`);
        }
    });
});
</script>

<style>
/* Validation Styles */
.validation-error {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: block;
    font-weight: 500;
}

.form-control.error {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-control.valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-group.has-error .form-control {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-group.has-error label {
    color: #dc3545;
}

/* Loading state for submit button */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading:after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Character counter styles */
.char-counter {
    display: block;
    margin-top: 5px;
    font-size: 12px;
}

.char-counter.text-warning {
    color: #ffc107 !important;
}

.char-counter.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush

