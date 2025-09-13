@extends('admin.layouts.app')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Dashboard',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
        ],
    ])


    <!-- Registration Details Section -->
    <div class="row">
        <!-- Junior Editor Registrations -->
        <x-dashboard-widget icon="bx bx-edit" title="Junior Editor Registrations"
            value="{{ $registrationDetails['junior_editors']['total'] }}" bg-color="info" />

        <!-- Today's Registrations -->
        <x-dashboard-widget icon="bx bx-calendar-check" title="Today's Registrations"
            value="{{ $registrationDetails['junior_editors']['today'] }}" bg-color="warning" />

        <!-- This Month's Registrations -->
        <x-dashboard-widget icon="bx bx-calendar" title="This Month's Registrations"
            value="{{ $registrationDetails['junior_editors']['this_month'] }}" bg-color="success" />

        <!-- Verified Registrations -->
        <x-dashboard-widget icon="bx bx-check-circle" title="Verified Registrations"
            value="{{ $registrationDetails['junior_editors']['verified'] }}" bg-color="primary" />

        <!-- Paid Registrations -->
        <x-dashboard-widget icon="bx bx-credit-card" title="Paid Registrations"
            value="{{ $registrationDetails['junior_editors']['paid'] }}" bg-color="success" />

        <!-- Certificate Students -->
        <x-dashboard-widget icon="bx bx-certificate" title="Certificate Students"
            value="{{ $registrationDetails['certificate_students']['total'] }}" bg-color="info" />
    </div>

    <!-- Contact Submissions Section -->
    <div class="row">
        <!-- Total Contact Submissions -->
        <x-dashboard-widget icon="bx bx-message-square-detail" title="Total Contact Submissions"
            value="{{ $registrationDetails['contact_submissions']['total'] }}" bg-color="primary" />

        <!-- Today's Contact Submissions -->
        <x-dashboard-widget icon="bx bx-message-square-add" title="Today's Contact Submissions"
            value="{{ $registrationDetails['contact_submissions']['today'] }}" bg-color="success" />

        <!-- This Month's Contact Submissions -->
        <x-dashboard-widget icon="bx bx-message-square" title="This Month's Contact Submissions"
            value="{{ $registrationDetails['contact_submissions']['this_month'] }}" bg-color="warning" />

        <!-- Last Month's Contact Submissions -->
        <x-dashboard-widget icon="bx bx-message-square-minus" title="Last Month's Contact Submissions"
            value="{{ $registrationDetails['contact_submissions']['last_month'] }}" bg-color="info" />
    </div>

    <!-- Employee Management Section -->
    <div class="row">
        <!-- Total Employees -->
        <x-dashboard-widget icon="bx bx-user-plus" title="Total Employees"
            value="{{ $registrationDetails['employees']['total'] }}" bg-color="primary" />

        <!-- Today's Employees -->
        <x-dashboard-widget icon="bx bx-user-check" title="Today's New Employees"
            value="{{ $registrationDetails['employees']['today'] }}" bg-color="success" />

        <!-- This Month's Employees -->
        <x-dashboard-widget icon="bx bx-user" title="This Month's New Employees"
            value="{{ $registrationDetails['employees']['this_month'] }}" bg-color="warning" />

        <!-- Last Month's Employees -->
        <x-dashboard-widget icon="bx bx-user-minus" title="Last Month's New Employees"
            value="{{ $registrationDetails['employees']['last_month'] }}" bg-color="info" />
    </div>


    <!-- Recent Data Tables -->
    <div class="row">
        <!-- Recent Junior Editor Registrations -->
        <div class="col-lg-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Recent Junior Editor Registrations</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrationDetails['recent_registrations'] as $index => $registration)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $registration['name'] }}</td>
                                        <td>{{ $registration['mobile'] }}</td>
                                        <td>{{ $registration['email'] }}</td>
                                        <td>{{ $registration['date'] }}</td>
                                        <td>
                                            @if($registration['payment_status'] == 'paid')
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
                                        <td colspan="6" class="text-center">No recent registrations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Contact Submissions -->
        <div class="col-lg-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Recent Contact Submissions</h5>
                    </div>
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
                                @forelse($registrationDetails['recent_contacts'] as $index => $contact)
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
                                        <td colspan="6" class="text-center">No recent contact submissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Employees Table -->
    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Recent Employee Additions</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrationDetails['recent_employees'] as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employee['employee_id'] }}</td>
                                        <td>{{ $employee['name'] }}</td>
                                        <td>{{ $employee['email'] }}</td>
                                        <td>{{ $employee['department'] }}</td>
                                        <td>{{ $employee['designation'] }}</td>
                                        <td>{{ $employee['date'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No recent employees found.</td>
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

