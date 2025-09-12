@extends('front.layouts.app')

@section('content')
<!-- Start Page Banner -->
<div class="page-banner-area item-bg2">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-banner-content">
                    <h2>{{ $content->title }}</h2>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>{{ $content->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner -->
<section class="privacy-policy-area ptb-100">
    <div class="container">
        <div class="privacy-policy-accordion">
        <div class="row">
            <div class="col-md-12">
                {!! $content->content !!}
            </div>
        </div>
        </div>
    </div>
</section>
@endsection