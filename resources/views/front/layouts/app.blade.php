<!doctype html>
<html lang="zxx" class="theme-light">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/animate.min.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/meanmenu.css') }}">
    <!-- Boxicons CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/boxicons.min.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css') }}">
    <!-- Owl Carousel Default CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.theme.default.min.css') }}">
    <!-- Odometer CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/odometer.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/magnific-popup.min.css') }}">
    <!-- Imagelightbox CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/imagelightbox.min.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <!-- Dark CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/dark.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css') }}">

    <title>Junior Editor</title>

    <link rel="icon" type="image/png" href="assets/img/favicon.png">
</head>

<body>
     <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="loader">
            <div class="wrapper">
                <div class="circle circle-1"></div>
                <div class="circle circle-1a"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader Area -->

    @include('front.layouts.header')   
    @yield('content')
    @include('front.layouts.footer')


    <!-- jQuery Slim JS -->
    <script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('front/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Meanmenu JS -->
    <script src="{{ asset('front/assets/js/jquery.meanmenu.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('front/assets/js/owl.carousel.min.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Imagelightbox JS -->
    <script src="{{ asset('front/assets/js/imagelightbox.min.js') }}"></script>
    <!-- Odometer JS -->
    <script src="{{ asset('front/assets/js/odometer.min.js') }}"></script>
    <!-- jQuery Appear JS -->
    <script src="{{ asset('front/assets/js/jquery.appear.min.js') }}"></script>
    <!-- Ajaxchimp JS -->
    <script src="{{ asset('front/assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <!-- Form Validator JS -->
    <script src="{{ asset('front/assets/js/form-validator.min.js') }}"></script>
    <!-- Contact JS -->
    <script src="{{ asset('front/assets/js/contact-form-script.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    
</body>

</html>