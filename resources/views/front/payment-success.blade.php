@extends('front.layouts.app')

@section('title', 'Payment Successful - Junior Editor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-success mb-3">Payment Successful!</h2>
                    <p class="lead mb-4">Thank you for your registration. Your payment has been processed successfully.</p>
                    <p class="mb-4">You will receive a confirmation email shortly with your registration details.</p>
                    <div class="alert alert-info">
                        <strong>Note:</strong> The activity sheet will be delivered to your registered address by courier / registered post in 8-10 working days.
                    </div>
                    <a href="{{ route('junior-editor.register') }}" class="btn btn-primary">Register Another Student</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
