@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.page-header', [
        'title' => 'Employee Management',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Employee Management' => route('admin.employees.index')
        ]
    ])

    @include('admin.layouts.partials.alert')

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                {{-- <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">All Employees ({{ $employees->total() }})</div>
                    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add New Employee
                    </a>
                </div> --}}
                <div class="card-body">
                    @if($employees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Phone Number</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $index => $employee)
                                        <tr>
                                            <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $index + 1 }}</td>
                                            <td><span class="badge bg-primary">{{ $employee->username }}</span></td>
                                            <td>{{ $employee->full_name }}</td>
                                            <td><a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a></td>
                                            <td><span class="badge bg-info">{{ $employee->department }}</span></td>
                                            <td><a href="tel:{{ $employee->mobile_number }}">{{ $employee->mobile_number }}</a></td>
                                            <td>
                                                @if($employee->status->value === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($employee->status->value === 'inactive')
                                                    <span class="badge bg-danger">Inactive</span>
                                                @else
                                                    <span class="badge bg-warning">Suspended</span>
                                                @endif
                                            </td>
                                            <td>{{ $employee->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.employees.show', $employee->id) }}" 
                                                       class="btn btn-sm btn-info" style="height: fit-content;">
                                                        <i class="bx bx-show"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $employees->links() }}
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="bx bx-info-circle"></i>
                            No employees found. <a href="{{ route('admin.employees.create') }}">Add the first employee</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
