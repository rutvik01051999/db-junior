@props(['participants'])

<section class="fun-facts-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            @if($participants && $participants->count() > 0)
                @foreach($participants as $index => $participant)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-fun-fact {{ $index % 4 == 0 ? '' : ($index % 4 == 1 ? 'bg-1' : ($index % 4 == 2 ? 'bg-2' : 'bg-3')) }}">
                            <h3>
                                <span class="odometer" data-count="{{ $participant->number_of_participants }}">00</span>
                            </h3>
                            <p>{{ $participant->title }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback participant statistics --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-fun-fact">
                        <h3>
                            <span class="odometer" data-count="1200">00</span>
                        </h3>
                        <p>Total Participants</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-fun-fact bg-1">
                        <h3>
                            <span class="odometer" data-count="305">00</span>
                        </h3>
                        <p>Participants State</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-fun-fact bg-2">
                        <h3>
                            <span class="odometer" data-count="48">00</span>
                        </h3>
                        <p>Participants Cities</p>
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
            @endif
        </div>
    </div>
</section>
