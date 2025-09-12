@extends('front.layouts.app')

@section('content')
  <!-- Start Page Banner -->
        <div class="page-banner-area">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="page-banner-content">
                            <h2>{{ __('contact.title') }}</h2>
                            <ul>
                                <li>
                                    <a href="{{ route('switch.english') }}">{{ __('contact.breadcrumb_home') }}</a>
                                </li>
                                <li>{{ __('contact.breadcrumb_contact') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Banner -->

   <!-- Start Contact Area -->
        <section class="contact-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-12">
                        <div class="contact-form">
                            <h3>{{ __('contact.form.title') }}</h3>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" required data-error="{{ __('contact.form.name_error') }}" placeholder="{{ __('contact.form.name_placeholder') }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" required data-error="{{ __('contact.form.email_error') }}" placeholder="{{ __('contact.form.email_placeholder') }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" required data-error="{{ __('contact.form.phone_error') }}" placeholder="{{ __('contact.form.phone_placeholder') }}">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" id="message" cols="30" rows="5" required data-error="{{ __('contact.form.message_error') }}" class="form-control" placeholder="{{ __('contact.form.message_placeholder') }}"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn">{{ __('contact.form.submit_button') }}</button>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12">
                        <div class="contact-information">
                            <h3>{{ __('contact.info.title') }}</h3>

                            <ul class="contact-list">
                                <li><i class='bx bx-map'></i> {{ __('contact.info.location_label') }} <span>{{ __('contact.info.location_value') }}</span></li>
                                <li><i class='bx bx-phone-call'></i> {{ __('contact.info.call_label') }} <a href="tel:+01321654214">+01 321 654 214</a></li>
                                <li><i class='bx bx-envelope'></i> {{ __('contact.info.email_label') }} <a href="mailto:hello@ketan.com">hello@ketan.com</a></li>
                                <li><i class='bx bx-microphone'></i> {{ __('contact.info.fax_label') }} <a href="tel:+123456789">+123456789</a></li>
                            </ul>

                            <h3>{{ __('contact.info.hours_title') }}</h3>
                            <ul class="opening-hours">
                                <li><span>{{ __('contact.info.monday') }}</span> {{ __('contact.info.hours') }}</li>
                                <li><span>{{ __('contact.info.tuesday') }}</span> {{ __('contact.info.hours') }}</li>
                                <li><span>{{ __('contact.info.wednesday') }}</span> {{ __('contact.info.hours') }}</li>
                                <li><span>{{ __('contact.info.thursday') }}</span> {{ __('contact.info.hours') }}</li>
                                <li><span>{{ __('contact.info.friday') }}</span> {{ __('contact.info.closed') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Area -->

<div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14663.335172103018!2d77.43137491032302!3d23.249134514247206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397c426615555555%3A0x31995b43706e2b62!2sDainik%20Bhaskar!5e0!3m2!1sen!2sin!4v1757669017504!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
@endsection

@include('front.contact-scripts')