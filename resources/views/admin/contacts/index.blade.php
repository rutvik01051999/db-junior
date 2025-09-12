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
                {{-- <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Contact Form Submissions
                    </div>
                    <div class="d-flex align-items-center justify-content-end flex-wrap">
                        <span class="badge bg-primary">{{ $contacts->total() }} Total Submissions</span>
                    </div>
                </div> --}}
                <div class="card-body">
                    @if($contacts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>IP Address</th>
                                        <th>Submitted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>
                                                <a href="mailto:{{ $contact->email }}" class="text-primary">
                                                    {{ $contact->email }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="tel:{{ $contact->phone_number }}" class="text-success">
                                                    {{ $contact->phone_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $contact->message }}">
                                                    {{ Str::limit($contact->message, 50) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $contact->ip_address }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ $contact->created_at->format('M d, Y H:i') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View Details" style="height: fit-content;">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this contact submission?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Delete">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $contacts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bx bx-message-square-x bx-lg text-muted"></i>
                            </div>
                            <h5 class="text-muted">No Contact Submissions Found</h5>
                            <p class="text-muted">There are no contact form submissions to display.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
