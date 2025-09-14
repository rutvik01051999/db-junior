@extends('front.layouts.app')

@section('title', 'Junior Editor - Order Your Copy')

@section('content')
<!-- Start Page Title Area -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>Junior Editor Registration</h2>
            <ul>
                
                <li>Register</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Title Area --> 

 <!-- Start Contact Area -->
       <section class="contact-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form">
                    <div class="section-title">
                        <h2>Order Your Copy Now</h2>
                        <p>Fill out the form below to register for Junior Editor competition</p>
                    </div>

                    <!-- Success Message (Hidden by default) -->
                    <div id="successMessage" class="alert alert-success" style="display: none;">
                        <i class="bx bx-check-circle"></i>
                        We received your message and you'll hear from us soon. Thank You!
                    </div>

                    <form id="orderForm">
                        @csrf
                        
                        <!-- Parent Details Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blue_label">
                                        <b>Parent Details</b>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="parent_name" name="parent_name" 
                                               placeholder="Father's / Mother's Name*" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="mobileno" name="mobileno" 
                                               placeholder="Mobile Number *" maxlength="10" 
                                               onkeypress="return restrictAlphabets(event)" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" class="default-btn" id="verify_otp" 
                                                onclick="VerifyMobile()">Get OTP</button>
                                    </div>
                                </div>
                        </div>

                        <!-- Student Details Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blue_label">
                                        <b>Student Details</b>
                                    </div>
                                    <hr>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               placeholder="First Name*" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                               placeholder="Last Name*" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                            <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Email*" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="birthdate" name="birthdate" 
                                               placeholder="Birthdate *" data-toggle="datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender<span class="red">*</span></label><br>
                                        <input type="radio" id="male" class="mr-1 gender_radio" name="gender" value="male" checked>
                                        <label for="male">Male</label>
                                        <input type="radio" class="ml-2 mr-1 gender_radio" name="gender" value="female" id="female">
                                        <label for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="address" name="address" 
                                                  placeholder="Full Address*" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pincode" name="pincode" 
                                               placeholder="Pincode*" maxlength="6" 
                                               onkeypress="return restrictAlphabets(event)" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="state" name="state" class="form-control" required>
                                            <option value="">--Select State--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="city" name="city" class="form-control" required>
                                            <option value="">--Select City--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- School Details Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blue_label">
                                        <b>School Details</b>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="school_name" name="school_name" 
                                               placeholder="School Name*" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="school_class" name="school_class" required>
                                            <option value="">--Select Class--</option>
                                            <option value="4">4th</option>
                                            <option value="5">5th</option>
                                            <option value="6">6th</option>
                                            <option value="7">7th</option>
                                            <option value="8">8th</option>
                                            <option value="9">9th</option>
                                            <option value="10">10th</option>
                                            <option value="11">11th</option>
                                            <option value="12">12th</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                            <div class="form-group">
                                        <input type="text" class="form-control" id="school_telephone_no" name="school_telephone_no" 
                                               placeholder="School Contact No*" maxlength="12" 
                                               onkeypress="return restrictAlphabets(event)" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                            <div class="form-group">
                                        <textarea class="form-control" id="school_address" name="school_address" 
                                                  placeholder="Full Address*" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Options Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blue_label">
                                        <b>Choose Your Delivery Option</b>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="row">
                                <div class="col-md-12" id="div_note" style="display:none;">
                                    <div class="alert alert-info">
                                        <b>Note: The activity sheet will be delivered to your registered address by courier / registered post in 8-10 working days.</b>
                                    </div>
                                </div>
                                <div class="col-md-12" id="div_note1" style="display:none;">
                                    <div class="alert alert-info">
                                        <b>Note: Once you have made the payment, you will get a digital receipt. Show this at the pick-up center to collect your worksheet.</b>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group">
                                        <select class="form-control" id="delivery_type" name="delivery_type" required>
                                    <option value="">--Select Delivery Type--</option>
                                    <option value="Door Step Delivery">Door Step Delivery</option>
                                    <option value="Self Pick Up">Self Pick Up</option>
                                </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" id="amount" name="amount">
                                        <input type="text" class="form-control" id="amount1" placeholder="Amount" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pickup Centers (for Self Pick Up) -->
                            <div class="row" id="div_tag" style="display:none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                <select id="pickup_centers" name="pickup_centers" class="form-control">
                                    <option value="">--Select Pickup Centers--</option>
                                    <option value="BHOPAL">BHOPAL</option>
                                    <option value="AURANGABAD">AURANGABAD</option>
                                            <option value="AMRITSAR">AMRITSAR</option>
                                            <option value="AHEMADABAD">AHEMADABAD</option>
                                            <option value="CHANDIGARH">CHANDIGARH</option>
                                    <option value="INDORE">INDORE</option>
                                            <option value="JAIPUR">JAIPUR</option>
                                            <option value="PATNA">PATNA</option>
                                            <option value="RANCHI">RANCHI</option>
                                            <option value="PANIPAT">PANIPAT</option>
                                            <option value="RAIPUR">RAIPUR</option>
                                            <option value="JALANDHAR">JALANDHAR</option>
                                            <option value="LUDHIANA">LUDHIANA</option>
                                </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <textarea class="form-control" id="office_address" name="office_address" 
                                                  placeholder="Office Address*" rows="2" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" id="div_tag_day" style="display:none;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="days" 
                                               value="Office Pickup day: Friday-Saturday" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row justify-content-center">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <input type="button" class="default-btn" onclick="Checkoutpayment();" value="Proceed">
                                  </div>
                              </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="main-banner-shape">
    <div class="shape-5">
        <img src="http://127.0.0.1:8000/front/assets/img/main-banner/banner-shape-5.png" alt="image">
    </div>

    <div class="shape-2">
        <img src="http://127.0.0.1:8000/front/assets/img/main-banner/banner-shape-2.png" alt="image">
    </div>

    <div class="shape-6">
        <img src="http://127.0.0.1:8000/front/assets/img/main-banner/banner-shape-6.png" alt="image">
    </div>

    <div class="shape-4">
        <img src="http://127.0.0.1:8000/front/assets/img/main-banner/banner-shape-4.png" alt="image">
    </div>
</div>
<!-- End Contact Area -->

<!-- OTP Verification Modal -->
<div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mobile Verification</h4>
            </div>
            <div class="modal-body">
                <p>Enter 6 Digit OTP. We just sent you on <span id='span_mobile'></span> mobile</p>
                <div class='form-row' style='margin-top: 10px;margin-bottom: 10px;'>
                    <div class='form-group col-md-8'>
                        <input type='text' class='form-control' placeholder='Please enter your otp' id='dialog_otp' maxlength="6" onkeypress="return restrictAlphabets(event)">
                    </div>
                    <div class='form-group col-md-4'>
                        <input type="button" class="default-btn form-control" value="Verify" id='check_otp'/>
                    </div>
        </div>
                <p style="text-align: right;">
                    <button type="button" id="resendCode" class="btn btn-link" disabled onclick="ResendCodeFromModal()">Resend OTP</button>
                    <span id="counter" style="color: blue;"></span>
                </p>
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
    @media (min-width: 992px) {
        .form-row{
            display: flex;
            gap: 8px;
        }
    }
    .blue_label {
        background: #ea512e;
        padding: 8px 15px;
        color: white;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }
    
    .form-section {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #f8f9fa;
    }
    
    .form-section hr {
        margin-top: 10px;
        margin-bottom: 20px;
        border-color: #dee2e6;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        margin-bottom: 10px;
    }
    
    .row {
        margin-bottom: 15px;
    }
    
    .row .form-group {
        margin-bottom: 15px;
    }
    
    .red {
        color: red;
    }
    
    .alert {
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .default-btn {
        background: linear-gradient(135deg, #ea512e 0%, #ff6b35 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .default-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }
    
    .default-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }
    
    .gender_radio {
        margin-right: 5px;
    }
    
    .modal-content {
        border-radius: 10px;
    }
    
    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 10px 10px 0 0;
    }
    
    .btn-link {
        color: #007bff;
        text-decoration: none;
    }
    
    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    
    /* Additional spacing for better form layout */
    .form-control {
        margin-bottom: 15px;
        padding: 12px 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    /* Spacing for radio buttons */
    .gender_radio {
        margin-right: 8px;
        margin-left: 15px;
    }
    
    .gender_radio:first-child {
        margin-left: 0;
    }
    
    /* Better spacing for form rows */
    .row .col-md-6,
    .row .col-md-4,
    .row .col-md-5,
    .row .col-md-3,
    .row .col-md-8,
    .row .col-md-12 {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    /* Section spacing */
    .form-section .row:not(:last-child) {
        margin-bottom: 20px;
    }
    
    /* Date input styling */
    input[type="date"] {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px 15px;
        width: 100%;
        color: #333;
    }
    
    input[type="date"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    /* Select dropdown styling */
    select.form-control {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px 15px;
        width: 100%;
        color: #333;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    select.form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    /* Ensure dropdowns work properly */
    select.form-control {
        size: 1 !important;
    }
    
    select.form-control:focus {
        size: 1 !important;
    }
    
    /* Fix any stuck dropdowns */
    select[multiple] {
        size: 1 !important;
    }
    
    /* jQuery Validation Styles */
    .validation-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        margin-bottom: 10px;
        display: block;
        font-weight: 500;
        width: 100%;
    }
    
    .form-control.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* .form-control.valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    } */
    
    .form-group.has-error .form-control {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .form-group.has-error label {
        color: #dc3545;
    }
    
    /* Radio button validation styles */
    .form-group.has-error .gender_radio {
        border: 2px solid #dc3545;
        border-radius: 3px;
        padding: 2px;
    }
    
    /* Select dropdown validation styles */
    select.form-control.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* select.form-control.valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    } */
    
    /* Textarea validation styles */
    textarea.form-control.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* textarea.form-control.valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    } */
    
    /* Success state for verified mobile */
    .mobile-verified {
        border-color: #28a745 !important;
        background-color: #d4edda;
    }
    
    /* Loading state for buttons */
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
    
    /* Select2 Custom Styling */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 48px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px 15px;
        background-color: white;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single {
        height: 48px;
        line-height: 24px;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        padding-right: 0;
        color: #333;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        height: 46px;
        right: 10px;
    }
    
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 8px 12px;
    }
    
    .select2-container--bootstrap-5 .select2-results__option {
        padding: 8px 12px;
    }
    
    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #ea512e;
        color: white;
    }
    
    .select2-container--bootstrap-5 .select2-results__option--selected {
        background-color: #f8f9fa;
        color: #333;
    }
    
    .select2-container--bootstrap-5 .select2-selection:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    /* Error state for Select2 */
    .select2-container--bootstrap-5.error .select2-selection {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Valid state for Select2 */
    .select2-container--bootstrap-5.valid .select2-selection {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    /* Error message positioning for Select2 dropdowns */
    .select2-container + .validation-error {
        margin-top: 5px;
        margin-bottom: 10px;
    }
    
    /* Ensure proper spacing for form groups with Select2 */
    .form-group .select2-container {
        margin-bottom: 0;
    }
    
    .form-group .select2-container + .validation-error {
        margin-top: 5px;
        margin-bottom: 10px;
    }
</style>
@endpush

@include('front.register-scripts')
