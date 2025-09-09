@props(['sliders'])

@if($sliders && $sliders->count() > 0)
    <div class="main-banner">
        <div class="home-slides owl-carousel owl-theme owl-loaded owl-drag" style="height: 80%;">
            <div class="owl-stage-outer owl-height" style="height: 865px;">
                <div class="owl-stage">
                    @foreach($sliders as $slider)
                        <div class="owl-item">
                            <div class="main-banner-item">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container-fluid">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="main-banner-image">
                                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
@else
    {{-- Fallback slider content --}}
    <div class="main-banner">
        <div class="home-slides owl-carousel owl-theme owl-loaded owl-drag" style="height: 80%;">
            <div class="owl-stage-outer owl-height" style="height: 865px;">
                <div class="owl-stage">
                    <div class="owl-item">
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
                    <div class="owl-item">
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
                    <div class="owl-item">
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
@endif
