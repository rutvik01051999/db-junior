@use('\App\Enums\UserStatus')
@extends('admin.layouts.app')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Activities',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Activities' => route('admin.activities.activity-logs.index'),
        ],
    ])

    @include('admin.layouts.partials.alert')

    <!-- Activity Statistics -->
    {{-- <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-primary">
                                <i class="bx bx-activity fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="fw-semibold text-muted d-block mb-1">Total Activities</span>
                            <h4 class="fw-semibold mb-0">{{ $activityStats['total_activities'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-info">
                                <i class="bx bx-globe fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="fw-semibold text-muted d-block mb-1">Page Loads</span>
                            <h4 class="fw-semibold mb-0">{{ $activityStats['page_loads'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-success">
                                <i class="bx bx-send fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="fw-semibold text-muted d-block mb-1">Form Submissions</span>
                            <h4 class="fw-semibold mb-0">{{ $activityStats['form_submissions'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-warning">
                                <i class="bx bx-download fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="fw-semibold text-muted d-block mb-1">Certificate Downloads</span>
                            <h4 class="fw-semibold mb-0">{{ $activityStats['certificate_downloads'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Activity Logs
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table([
                            'class' => 'w-100 table-striped table-hover table-bordered',
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
