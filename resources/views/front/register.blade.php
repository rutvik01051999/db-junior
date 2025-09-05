@extends('front.layouts.app')
 <!-- Start Contact Area -->
       <section class="contact-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="contact-form">
                    <h3>Order Your Copy Now</h3>

                    <form id="orderForm">
                        <!-- Parent Details -->
                        <div class="form-section">
                            <small class="blue_label"><b>Parent Details</b></small>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="parent_name" name="parent_name" class="form-control" required placeholder="Father's / Mother's Name*">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="mobileno" name="mobileno" maxlength="10" class="form-control" required placeholder="Mobile Number*" onkeypress="return restrictAlphabets(event)">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="default-btn w-100" onclick="VerifyMobile()">Get OTP</button>
                                </div>
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="form-section mt-4">
                            <small class="blue_label"><b>Student Details</b></small>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="first_name" name="first_name" class="form-control" required placeholder="First Name*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="last_name" name="last_name" class="form-control" required placeholder="Last Name*">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" required placeholder="Email*">
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="birthdate" name="birthdate" class="form-control" required placeholder="Birthdate*" data-toggle="datepicker" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="d-block">Gender <span class="red">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea id="address" name="address" class="form-control" required placeholder="Full Address*" rows="2"></textarea>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="pincode" name="pincode" class="form-control" maxlength="6" required placeholder="Pincode*" onkeypress="return restrictAlphabets(event)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="state" name="state" class="form-control select2" required>
                                            <option value="">Select State</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Delhi">Delhi</option>
                                            <!-- add rest of states -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="city" name="city" class="form-control select2" required>
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- School Details -->
                        <div class="form-section mt-4">
                            <small class="blue_label"><b>School Details</b></small>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="school_name" name="school_name" class="form-control" required placeholder="School Name*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="school_class" name="school_class" class="form-control" required>
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
                            </div><br>
                            <div class="form-group">
                                <input type="text" id="school_telephone_no" name="school_telephone_no" class="form-control" maxlength="12" required placeholder="School Contact No">
                            </div><br>
                            <div class="form-group">
                                <textarea id="school_address" name="school_address" class="form-control" required placeholder="Full Address*" rows="2"></textarea>
                            </div>
                        </div>

                        <!-- Delivery Option -->
                        <div class="form-section mt-4">
                            <small class="blue_label"><b>Choose Your Delivery Option</b></small>
                            <hr>
                            <div class="form-group">
                                <select id="delivery_type" name="delivery_type" class="form-control" required>
                                    <option value="">--Select Delivery Type--</option>
                                    <option value="Door Step Delivery">Door Step Delivery</option>
                                    <option value="Self Pick Up">Self Pick Up</option>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <input type="text" id="amount1" name="amount1" class="form-control" readonly placeholder="Amount">
                                <input type="hidden" id="amount" name="amount">
                            </div>
                            <div class="form-group" id="pickup_centers_wrap" style="display:none;">
                                <select id="pickup_centers" name="pickup_centers" class="form-control">
                                    <option value="">--Select Pickup Centers--</option>
                                    <option value="BHOPAL">BHOPAL</option>
                                    <option value="AURANGABAD">AURANGABAD</option>
                                    <option value="INDORE">INDORE</option>
                                </select>
                            </div><br>
                            <div class="form-group" id="office_address_wrap" style="display:none;">
                                <textarea id="office_address" name="office_address" class="form-control" rows="2" readonly placeholder="Office Address*"></textarea>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="default-btn">Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
              <div class="main-banner-shape">
        <div class="shape-5">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-5.png') }}" alt="image">
        </div>

        <div class="shape-2">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-2.png') }}" alt="image">
        </div>

        <div class="shape-6">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-6.png') }}" alt="image">
        </div>

        <div class="shape-4">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-4.png') }}" alt="image">
        </div>
    </div>
        </div>
    </div>
</section>

        <!-- End Contact Area -->