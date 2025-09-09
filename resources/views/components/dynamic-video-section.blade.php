@props(['videos'])

@if($videos && $videos->count() > 0)
    <section class="class-area bg-fdf6ed pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row1">
                        @foreach($videos as $video)
                            <video preload="metadata" controls="" style="height: 500px;width: 100%;" class="mb-4">
                                <source src="{{ $video->video_url }}" type="video/mp4">
                                @if($video->title)
                                    <p>{{ $video->title }}</p>
                                @endif
                            </video>
                        @endforeach
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
@else
    {{-- Fallback video content --}}
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
@endif
