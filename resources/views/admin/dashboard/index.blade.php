@extends('admin.layouts.app')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Dashboard',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
        ],
    ])

    <!-- Module Statistics Cards -->
    <div class="row">
        <!-- Junior Editor Registrations -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-primary">
                                <i class="bx bx-edit fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-semibold text-muted d-block mb-1">Registered Users</span>
                                    <h4 class="fw-semibold mb-0">{{ $moduleStats['junior_editors']['total'] }}</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i>
                                        {{ $moduleStats['junior_editors']['today'] }} today
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Winner Management -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-success">
                                <i class="bx bx-trophy fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-semibold text-muted d-block mb-1">Winners</span>
                                    <h4 class="fw-semibold mb-0">{{ $moduleStats['winners']['total'] }}</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-info">
                                        <i class="bx bx-layer"></i>
                                        {{ $moduleStats['winners']['batches'] }} batches
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Submissions -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-warning">
                                <i class="bx bx-message-dots fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-semibold text-muted d-block mb-1">Contacts</span>
                                    <h4 class="fw-semibold mb-0">{{ $moduleStats['contacts']['total'] }}</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i>
                                        {{ $moduleStats['contacts']['today'] }} today
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Management -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="avatar bg-info">
                                <i class="bx bx-user fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-semibold text-muted d-block mb-1">Employees</span>
                                    <h4 class="fw-semibold mb-0">{{ $moduleStats['employees']['total'] }}</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i>
                                        {{ $moduleStats['employees']['today'] }} today
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics Row -->
    <div class="row">
        <!-- Junior Editor Details -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h6 class="mb-0">Junior Editor Stats</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Verified</span>
                        <span class="fw-semibold text-success">{{ $moduleStats['junior_editors']['verified'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Paid</span>
                        <span class="fw-semibold text-primary">{{ $moduleStats['junior_editors']['paid'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">This Month</span>
                        <span class="fw-semibold text-info">{{ $moduleStats['junior_editors']['this_month'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Winner Details -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h6 class="mb-0">Winner Stats</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Batches</span>
                        <span class="fw-semibold text-success">{{ $moduleStats['winners']['batches'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Today</span>
                        <span class="fw-semibold text-primary">{{ $moduleStats['winners']['today'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">This Month</span>
                        <span class="fw-semibold text-info">{{ $moduleStats['winners']['this_month'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h6 class="mb-0">Contact Stats</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total</span>
                        <span class="fw-semibold text-success">{{ $moduleStats['contacts']['total'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Today</span>
                        <span class="fw-semibold text-primary">{{ $moduleStats['contacts']['today'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">This Month</span>
                        <span class="fw-semibold text-info">{{ $moduleStats['contacts']['this_month'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h6 class="mb-0">Employee Stats</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total</span>
                        <span class="fw-semibold text-success">{{ $moduleStats['employees']['total'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Today</span>
                        <span class="fw-semibold text-primary">{{ $moduleStats['employees']['today'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">This Month</span>
                        <span class="fw-semibold text-info">{{ $moduleStats['employees']['this_month'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="row">
        <!-- Recent Junior Editor Registrations -->
        <div class="col-xl-6 col-lg-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        <h6 class="mb-0">Recent Junior Editor Registrations</h6>
                    </div>
                    <a href="{{ route('admin.junior-editor-registrations.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moduleStats['recent_junior_editors'] as $index => $registration)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $registration['name'] }}</td>
                                        <td>{{ $registration['mobile'] }}</td>
                                        <td>{{ $registration['date'] }}</td>
                                        <td>
                                            @if($registration['payment_status'] == 'completed')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($registration['payment_status'] == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent registrations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Winners -->
        <div class="col-xl-6 col-lg-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        <h6 class="mb-0">Recent Winners</h6>
                    </div>
                    <a href="{{ route('admin.winners.index') }}" class="btn btn-sm btn-success">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Batch</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moduleStats['recent_winners'] as $index => $winner)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $winner['name'] }}</td>
                                        <td>{{ $winner['mobile'] }}</td>
                                        <td>
                                            <span class="badge bg-info">#{{ $winner['batch'] }}</span>
                                        </td>
                                        <td>{{ $winner['date'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent winners found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        <h6 class="mb-0">Recent Contact Submissions</h6>
                    </div>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-warning">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moduleStats['recent_contacts'] as $index => $contact)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $contact['name'] }}</td>
                                        <td>{{ $contact['email'] }}</td>
                                        <td>{{ $contact['phone'] }}</td>
                                        <td>{{ $contact['message'] }}</td>
                                        <td>{{ $contact['date'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No recent contact submissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

