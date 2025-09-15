@extends('front.layouts.app')

<style>
.bxl-instagram{
margin-top: 8px;
}
.bxl-facebook{
    margin-top: 8px;
}
</style>

{{-- Dynamic Banner Section --}}
<div class="main-banner main-banner-home">
    <x-dynamic-banner :bannerSections="$bannerSections" />
    
    <div class="main-banner-shape">
        <div class="shape-5">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-5.png') }}" alt="image">
        </div>

        {{-- <div class="shape-2">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-2.png') }}" alt="image">
        </div> --}}

        <div class="shape-6">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-6.png') }}" alt="image">
        </div>

        <div class="shape-4">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-4.png') }}" alt="image">
        </div>
    </div>
</div>

{{-- Dynamic Main Content Section --}}
<x-dynamic-main-content :mainContent="$mainContent" />

{{-- Dynamic Video Section --}}
<x-dynamic-video-section :videos="$videos" />


{{-- Dynamic Process Section --}}
<x-dynamic-process :processes="$processes" />

{{-- Dynamic Participant Fun Facts Section --}}
<x-dynamic-participant-facts :participants="$participants" />

{{-- <section class="value-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="value-item who-we-are-content">
                    <div class="value-content">
                        <h3>Guest Of Honour</h3>
                    </div>

                    <ul class="who-we-are-list">
                        <li>
                            <span>1</span>
                            JE - 1. General VK Singh (Retd.)
                        </li>
                        <li>
                            <span>2</span>
                            JE - 2. Late Shri Ramesh Chandra Agarwal Ji (Chairman of the Dainik Bhaskar Group)
                        </li>
                        <li>
                            <span>3</span>
                            JE - 3. Shri Anna Hazare (Indian Social Activist)
                        </li>
                        <li>
                            <span>4</span>
                            JE - 4. Smt. Smriti Irani (Union Minister)
                        </li>
                        <li>
                            <span>5</span>
                            JE - 5. Mr. Anand Kumar (Super 30 Fame)
                        </li>
                        <li>
                            <span>6</span>
                            JE - 6. Deepa Malik (International Para athlete, Padma Shree & Arjun Awardee).
                        </li>
                        <li>
                            <span>7</span>
                            JE - 7. Shri Jagdeep Dhankhar, The Hon'ble Vice President of India.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="value-shape">
        <div class="shape-1">
            <img src="{{ asset('front/assets/img/value/value-shape-1.png') }}" alt="image">
</div>
<!-- <div class="shape-2">
            <img src="{{ asset('front/assets/img/value/value-shape-2.png') }}" alt="image">
        </div> -->
<div class="shape-3">
    <img src="{{ asset('front/assets/img/value/value-shape-3.png') }}" alt="image">
</div>
</div>
</section> --}}

<!-- Start Choose Area -->
{{-- <section class="choose-area pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <h2>Guest Of Honour</h2>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 1</h3>
                                <p>General VK Singh (Retd.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 10</h3>
                                <p>Late Shri Ramesh Chandra Agarwal Ji (Chairman of the Dainik Bhaskar Group)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 1</h3>
                                <p>General VK Singh (Retd.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 1</h3>
                                <p>General VK Singh (Retd.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 1</h3>
                                <p>General VK Singh (Retd.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-choose">
                            <div class="icon">
                                <i class='bx bx-happy'></i>
                            </div>

                            <div class="content">
                                <h3>JE - Season 1</h3>
                                <p>General VK Singh (Retd.)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!-- End Choose Area -->

{{-- Dynamic Guest Of Honour Section --}}
<x-dynamic-guest-of-honour :guestOfHonours="$guestOfHonours" />


{{-- Dynamic Slider Section --}}
<x-dynamic-slider :sliders="$sliders" />
{{-- <div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9476519598093!2d-73.99185268459418!3d40.74117737932881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a3f81d549f%3A0xb2a39bb5cacc7da0!2s175%205th%20Ave%2C%20New%20York%2C%20NY%2010010%2C%20USA!5e0!3m2!1sen!2sbd!4v1588746137032!5m2!1sen!2sbd"></iframe>
</div> --}}
<!-- Start Quote Area -->
<!-- <section class="quote-area bg-item ptb-100">
    <div class="container">
        <div class="quote-item item-two">
            <div class="content">
                <h3>Contact Us</h3>
            </div>

            <form id="contactForm" novalidate="true">
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" required="" data-error="Please enter your name" placeholder="Your name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" required="" data-error="Please enter your email" placeholder="Your email address">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required="" data-error="Please enter your phone number" placeholder="Your phone number">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="subjects" id="subjects" class="form-control" required="" data-error="Please enter your subjects" placeholder="Subjects">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <textarea name="message" id="message" cols="30" rows="5" required="" data-error="Please enter your message" class="form-control" placeholder="Write your message..."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <button type="submit" class="default-btn disabled" style="pointer-events: all; cursor: pointer;">Send Message</button>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section> -->
<!-- End Quote Area -->