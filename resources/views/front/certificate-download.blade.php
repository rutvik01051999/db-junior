@extends('front.layouts.app')
<br><br>
<section class="class-area bg-fdf6ed pt-100 pb-70">
    <div class="container">
        <div class="privacy-policy-accordion">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Certificate Download</h3>
                            <p>
                                To download your participation certificate, please enter your unique code in the input
                                field below and click the <b>"Download Certificate"</b> button. Your certificate will be
                                generated and downloaded automatically.
                            </p>

                                @csrf
                                <div class="form-group mb-3">
                                    <label for="mobile_number" class="form-label">Enter Your Mobile Number:</label>
                                     <input class="register-input white-input form-control" required=""
                                       placeholder="Register Mobile Number *" type="text" id="mobileno" maxlength="10"
                                       onkeypress="return restrictAlphabets(event)">
                                </div>
                                <button class="register-submit btn btn-primary w-100" id="verify_otp"
                                       onclick="VerifyMobile()" type="submit">Download Certificate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="class-shape">
        <div class="shape-1">
            <img src="{{ asset('front/assets/img/class/class-shape-1.png') }}" alt="image">
        </div>
        <div class="shape-2">
            <img src="{{ asset('front/assets/img/class/class-shape-2.png') }}" alt="image">
        </div>
    </div>
    
</section>
