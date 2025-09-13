@extends('admin.layouts.app')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Contact Form Submissions',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Contact Submissions' => route('admin.contacts.index'),
        ],
    ])

    @include('admin.layouts.partials.alert')

    <!-- Contact Submissions Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Contact Form Submissions
                    </div>
                </div>
                <div class="card-body">
                    {!! $dataTable->table(['class' => 'table table-bordered table-striped']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush