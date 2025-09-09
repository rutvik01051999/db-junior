@props(['guestOfHonours'])

<section class="activities-area pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <h2>Guest Of Honour</h2>
        </div>

        <div class="row">
            @if($guestOfHonours && $guestOfHonours->count() > 0)
                @foreach($guestOfHonours as $index => $guest)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-activities">
                            {{-- <div class="number">
                                <span class="{{ $index % 6 == 0 ? '' : ($index % 6 == 1 ? 'bg-2' : ($index % 6 == 2 ? 'bg-3' : ($index % 6 == 3 ? 'bg-4' : ($index % 6 == 4 ? 'bg-5' : 'bg-6')))) }}">{{ $guest->season_name }}</span>
                            </div> --}}
                            <div class="activities-content">
                                <div class="guest-of-honour-number" style="text-align: center;">
                                    <span class="{{ $index % 6 == 0 ? '' : ($index % 6 == 1 ? 'bg-2' : ($index % 6 == 2 ? 'bg-3' : ($index % 6 == 3 ? 'bg-4' : ($index % 6 == 4 ? 'bg-5' : 'bg-6')))) }}" style="
                                    font-size: x-large;
                                    font-weight: 700;
                                ">{{ $guest->season_name }}</span>
                                    <p>{{ $guest->guest_name }}</p>
                                </div>
                                {{-- <h3>
                                    <a href="#">{{ $guest->season_name }}</a>
                                </h3> --}}
                                {{-- <p>{{ $guest->guest_name }}</p> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback guest of honour content --}}
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
                                <a href="#">JE - Season 2</a>
                            </h3>
                            <p>Late Shri Ramesh Chandra Agarwal Ji (Chairman of the Dainik Bhaskar Group)</p>
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
                                <a href="#">JE - Season 3</a>
                            </h3>
                            <p>Shri Anna Hazare (Indian Social Activist)</p>
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
                                <a href="#">JE - Season 4</a>
                            </h3>
                            <p>Smt. Smriti Irani (Union Minister)</p>
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
                                <a href="#">JE - Season 5</a>
                            </h3>
                            <p>Mr. Anand Kumar (Super 30 Fame)</p>
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
                                <a href="#">JE - Season 6</a>
                            </h3>
                            <p>Deepa Malik (International Para athlete, Padma Shree & Arjun Awardee)</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
