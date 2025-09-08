@extends('front.layouts.app')

<!-- <div class="main-banner-item banner-item-three">
    <div class="main-banner-content">
        <img src="{{ asset('front/assets/img/Logo.jpg') }}" alt="image" style="width: 270px !important;margin-top: 120px;">
    </div>
    <br>
    <h4 style="text-align:center;margin-top: -15px;color: #2882C3;" class="mb-4">The Largest Newspaper Making Competition</h4>
</div> -->


<div class="main-banner">
    <div class="main-banner-item banner-item-two">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="main-banner-image-wrap">
                                <img src="{{ asset('front/assets/img/1.jpeg') }}" alt="image">

                                <div class="banner-image-wrap-shape">
                                    <img src="{{ asset('front/assets/img/main-banner/main-banner-shape-1.png') }}" alt="image">
                                </div>

                            </div>
                            <br>
                            <p style="max-width: 100%;"><b>The Hon'ble Vice President of India, Shri Jagdeep Dhankhar, along with the national winners of Junior Editor - 7, at the Felicitation Ceremony held at <br>Sansad Bhavan, New Delhi, on July 18th, 2024.</b></p>

                        </div>
                    </div>
                </div>
            </div>
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

<section class="who-we-are ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="who-we-are-content" id="about">
                    <h3>Junior Editor</h3>
                    <p>Junior Editor (JE) is India's Largest Newspaper Making Competition which is a pre-designed four-page broadsheet layout. Junior Editor is a unique activity for children that blends the elements of editing, designing, reporting, and creative writing. JE gives you a chance to create your own newspaper by making headlines, crafting stories, and writing editorials. Specific guidelines in the broadsheet will help you through the writing and illustration process. Junior Editor has clinched the highest honours from multiple distinguished organizations. It has been acknowledged by the 'Guinness World Records' (The Largest Writing Competition), the 'Limca World Record' (The Largest Countrywide Newspaper Making Competition for Children), and the India Book of Records for producing the most hand-made newspapers by children. Junior Editor is available in three editions : Dainik Bhaskar, Divya Bhaskar and Divya Marathi. You have the opportunity to create your own newspaper in either Hindi, English, Gujarati, or Marathi.</p>
                    <br>
                    <h4>Participation Categories
                    </h4>
                    <ul class="who-we-are-list">
                        <li style="display: flex;">
                            <span>1</span>
                            <h6>Category A</h6>- Class 4th, 5th and 6th
                        </li>
                        <li style="display: flex;">
                            <span>1</span>
                            <h6>Category A</h6> - Class 4th, 5th and 6th
                        </li>
                        <li style="display: flex;">
                            <span>1</span>
                            <h6>Category A</h6>- Class 4th, 5th and 6th
                        </li>
                        <li style="display: flex;">
                            <span>1</span>
                            <h6>Category A</h6> - Class 4th, 5th and 6th
                        </li>
                    </ul>
                    <br>
                    <h4>Timeline
                    </h4>
                    <ul class="who-we-are-list">
                        <li>
                            <span>1</span>
                            Registration Starts: 4th December, 2023
                        </li>
                        <li>
                            <span>1</span>
                            Registration Starts: 4th December, 2023
                        </li>
                        <li>
                            <span>1</span>
                            Registration Starts: 4th December, 2023
                        </li>
                        <li>
                            <span>1</span>
                            Registration Starts: 4th December, 2023
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="who-we-are-image-wrap shadow-custom">
                    <img src="{{ asset('front/assets/img/quote.jpg') }}" alt="image">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Start Value Area -->

<section class="class-area bg-fdf6ed pt-100 pb-70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row1">
                    <video preload="metadata" controls="" style="height: 500px;width: 100%;">
                        <source src="{{ asset('front/assets/video/JE_HI_New.mp4#t=0.01') }}" type="video/mp4">
                    </video>
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

<!-- End Value Area -->
<section class="value-area ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="value-image">
                    <img src="{{ asset('front/assets/img/value/value-1.png') }}" alt="image">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="value-item">
                    <div class="value-content">
                        <h3>We are Refunding Early Childcare Education</h3>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span>01</span>
                        </div>
                        <h4>Active Learning</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-2">02</span>
                        </div>
                        <h4>Safe Environment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-3">03</span>
                        </div>
                        <h4>Fully Equipment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>

            


            <div class="col-lg-6">
                <div class="value-item">
                    <div class="value-content">
                        <h3>We are Refunding Early Childcare Education</h3>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span>01</span>
                        </div>
                        <h4>Active Learning</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-2">02</span>
                        </div>
                        <h4>Safe Environment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-3">03</span>
                        </div>
                        <h4>Fully Equipment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="value-image">
                    <img src="{{ asset('front/assets/img/value/value-1.png') }}" alt="image">
                </div>
            </div>

           
            <div class="col-lg-6">
                <div class="value-image">
                    <img src="{{ asset('front/assets/img/value/value-1.png') }}" alt="image">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="value-item">
                    <div class="value-content">
                        <h3>We are Refunding Early Childcare Education</h3>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span>01</span>
                        </div>
                        <h4>Active Learning</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-2">02</span>
                        </div>
                        <h4>Safe Environment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="value-inner-content">
                        <div class="number">
                            <span class="bg-3">03</span>
                        </div>
                        <h4>Fully Equipment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
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

<!-- Start Fun Facts Area -->
<section class="fun-facts-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-fun-fact">
                    <h3>
                        <span class="odometer" data-count="1200">00</span>
                    </h3>
                    <p>
                        Total Participants</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-fun-fact bg-1">
                    <h3>
                        <span class="odometer" data-count="305">00</span>
                    </h3>
                    <p>
                        Participants State </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-fun-fact bg-2">
                    <h3>
                        <span class="odometer" data-count="48">00</span>
                    </h3>
                    <p>
                        Participants Cities</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-fun-fact bg-3">
                    <h3>
                        <span class="odometer" data-count="50">00</span>
                    </h3>
                    <p>Participant Schools</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Fun Facts Area -->

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

<!-- Start Activities Area -->
<section class="activities-area pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <h2>Guest Of Honour</h2>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span>01</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>General VK Singh (Retd.)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span class="bg-2">02</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>General VK Singh (Retd.)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span class="bg-3">03</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>General VK Singh (Retd.)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span class="bg-4">04</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>General VK Singh (Retd.)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span class="bg-5">05</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>General VK Singh (Retd.)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-activities">
                    <div class="number">
                        <span class="bg-6">06</span>
                    </div>
                    <div class="activities-content">
                        <h3>
                            <a href="#">JE - Season 1</a>
                        </h3>
                        <p>Late Shri Ramesh Chandra Agarwal Ji (Chairman of the Dainik Bhaskar Group)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Activities Area -->


<div class="main-banner">
    <div class="home-slides owl-carousel owl-theme owl-loaded owl-drag" style="height: 80%;">
        <div class="owl-stage-outer owl-height" style="height: 865px;">
            <div class="owl-stage" style="transform: translate3d(-5712px, 0px, 0px); transition: 0.25s; width: 11424px;">
                <div class="owl-item cloned" style="width: 1904px;">
                    <div class="main-banner-item">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="main-banner-image">
                                                <img src="{{ asset('front/assets/img/2.jpeg') }}" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-item cloned" style="width: 1904px;">
                    <div class="main-banner-item">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="main-banner-image">
                                                <img src="{{ asset('front/assets/img/3.jpeg') }}" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-item" style="width: 1904px;">
                    <div class="main-banner-item">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="main-banner-image">
                                                <img src="{{ asset('front/assets/img/4.jpeg') }}" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="owl-nav">
            <button type="button" role="presentation" class="owl-prev">
                <i class="bx bx-chevron-left"></i>
            </button>
            <button type="button" role="presentation" class="owl-next">
                <i class="bx bx-chevron-right"></i>
            </button>
        </div>
        <div class="owl-dots disabled"></div>
    </div>

    <div class="main-banner-shape">
        <div class="banner-bg-shape">
            <img src="{{ asset('front/assets/img/main-banner/banner-bg-shape-1.png') }}" class="white-image" alt="image">
            <img src="{{ asset('front/assets/img/main-banner/banner-bg-shape-1-dark.png') }}" class="black-image" alt="image">
        </div>

        <div class="shape-1">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-1.png') }}" alt="image">
        </div>

        <div class="shape-2">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-2.png') }}" alt="image">
        </div>

        <div class="shape-3">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-3.png') }}" alt="image">
        </div>

        <div class="shape-4">
            <img src="{{ asset('front/assets/img/main-banner/banner-shape-4.png') }}" alt="image">
        </div>
    </div>
</div>
<div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9476519598093!2d-73.99185268459418!3d40.74117737932881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a3f81d549f%3A0xb2a39bb5cacc7da0!2s175%205th%20Ave%2C%20New%20York%2C%20NY%2010010%2C%20USA!5e0!3m2!1sen!2sbd!4v1588746137032!5m2!1sen!2sbd"></iframe>
</div>
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