<!-- Start Navbar Area -->
<div class="navbar-area is-sticky">
    <div class="main-responsive-nav">
        <div class="container">
            <div class="main-responsive-menu">
                <div class="logo">
                    <a href="/">
                        <img src="{{ asset('front/assets/img/Logo.jpg') }}" class="black-logo" alt="image">
                        <img src="{{ asset('front/assets/img/logo-2.png') }}" class="white-logo" alt="image">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-navbar">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('front/assets/img/Logo.jpg') }}" class="black-logo" alt="image" style="width: 110px !important;">
                    <img src="{{ asset('front/assets/img/logo-2.png') }}" class="white-logo" alt="image">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link active">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#about" class="nav-link">
                                About
                            </a>
                        </li>

                       <li class="nav-item">
                            <a href="/register/form" class="nav-link">
                                Register
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/certificate" class="nav-link">
                                Certificate
                            </a>
                        </li>

                          <li class="nav-item">
                            <a href="#" class="nav-link text-primary" style="font-weight: 900;">
                                School Level Winners
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="#" class="nav-link text-danger" style="font-weight: 900;">
                                City Level Winners
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="#" class="nav-link text-success" style="font-weight: 900;">
                                State Level Winners
                            </a>
                          </li>

                           <li class="nav-item">
                            <a href="#" class="nav-link text-warning" style="font-weight: 900;">
                                National Level Winners
                            </a>
                          </li>

                        {{-- <li class="nav-item">
                            <a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vTQ0z_MA-W2wLo6eQDeR2k0exYtG8Z-7wLEwscTkZ8hd6EHmV6JgZ26-ZRpdQ1uRQ/pubhtml#" class="winner-btn" target="_blank" style="padding: 5px !important;margin-left: 10px;font-size: 14px !important;background: #2584C6 !important;">School Level Winners</a>
                        </li>

                        <li class="nav-item">
                            <a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vTQ0z_MA-W2wLo6eQDeR2k0exYtG8Z-7wLEwscTkZ8hd6EHmV6JgZ26-ZRpdQ1uRQ/pubhtml#" class="nav-link winner-btn" target="_blank" style="padding: 5px !important;margin-left: 10px;font-size: 14px !important;background: #d4e157 !important;border: 1px solid #d4e157;color: #1b5e20 !important;">School Level Winners</a>
                        </li>

                        <li class="nav-item">
                            <a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vTQ0z_MA-W2wLo6eQDeR2k0exYtG8Z-7wLEwscTkZ8hd6EHmV6JgZ26-ZRpdQ1uRQ/pubhtml#" class="nav-link winner-btn" target="_blank" style="padding: 5px !important;margin-left: 10px;font-size: 14px !important;background: #ffe0b2 !important;border: 1px solid #ffe0b2;color: #4e342e !important;">School Level Winners</a>
                        </li>

                         <li class="nav-item">
                            <a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vTQ0z_MA-W2wLo6eQDeR2k0exYtG8Z-7wLEwscTkZ8hd6EHmV6JgZ26-ZRpdQ1uRQ/pubhtml#" class="nav-link winner-btn" target="_blank" style="padding: 5px !important;margin-left: 10px;font-size: 14px !important;background: #e1bee7 !important;border: 1px solid #e1bee7;color: #4a148c !important;">School Level Winners</a>
                        </li> --}}
                    </ul>

                    <div class="others-options d-flex align-items-center">
                        <div class="option-item">
                            <div class="dropdown language-switcher d-inline-block">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>{{ $currentLanguage == 'hi' ? 'हिंदी' : 'English' }} <i class='bx bx-chevron-down'></i></span>
                                </button>

                                <div class="dropdown-menu">
                                    <a href="{{ route('switch.english') }}" class="dropdown-item d-flex align-items-center {{ $currentLanguage == 'en' ? 'active' : '' }}">
                                        <img src="{{ asset('front/assets/img/english.png') }}" class="shadow-sm" alt="flag">
                                        <span>English</span>
                                    </a>
                                    <a href="{{ route('switch.hindi') }}" class="dropdown-item d-flex align-items-center {{ $currentLanguage == 'hi' ? 'active' : '' }}">
                                        <img src="{{ asset('front/assets/img/india.jpg') }}" class="shadow-sm" alt="flag">
                                        <span>हिंदी</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="option-item">
                            <a href="/contact" class="default-btn">Contact Us</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="others-option-for-responsive">
        <div class="container">
            <div class="dot-menu">
                <div class="inner">
                    <div class="circle circle-one"></div>
                    <div class="circle circle-two"></div>
                    <div class="circle circle-three"></div>
                </div>
            </div>

            <div class="container">
                <div class="option-inner">
                    <div class="others-options d-flex align-items-center">
                        <div class="option-item">
                            <div class="dropdown language-switcher d-inline-block">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>{{ $currentLanguage == 'hi' ? 'हिंदी' : 'English' }} <i class='bx bx-chevron-down'></i></span>
                                </button>

                                <div class="dropdown-menu">
                                    <a href="{{ route('switch.english') }}" class="dropdown-item d-flex align-items-center {{ $currentLanguage == 'en' ? 'active' : '' }}">
                                        <img src="{{ asset('front/assets/img/english.png') }}" class="shadow-sm" alt="flag">
                                        <span>English</span>
                                    </a>
                                    <a href="{{ route('switch.hindi') }}" class="dropdown-item d-flex align-items-center {{ $currentLanguage == 'hi' ? 'active' : '' }}">
                                        <img src="{{ asset('front/assets/img/english.png') }}" class="shadow-sm" alt="flag">
                                        <span>हिंदी</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="option-item">
                            <a href="/contact" class="default-btn">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Navbar Area -->