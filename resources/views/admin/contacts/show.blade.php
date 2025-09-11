@extends('admin.layouts.app')

@section('content')
    <!-- Page Header -->
    @include('admin.layouts.partials.page-header', [
        'title' => 'Contact Form Details',
        'breadcrumb' => [
            'Home' => route('admin.dashboard.index'),
            'Contact Submissions' => route('admin.contacts.index'),
            'Contact Details' => route('admin.contacts.show', $contact),
        ],
    ])

    @include('admin.layouts.partials.alert')

    <!-- Contact Details -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">
                        Contact Form Submission #{{ $contact->id }}
                    </div>
                    <div class="d-flex align-items-center justify-content-end flex-wrap">
                        <span class="badge bg-primary">{{ $contact->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <div class="form-control-plaintext">{{ $contact->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="form-control-plaintext">
                                    <a href="mailto:{{ $contact->email }}" class="text-primary">
                                        {{ $contact->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="form-control-plaintext">
                                    <a href="tel:{{ $contact->phone_number }}" class="text-success">
                                        {{ $contact->phone_number }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">IP Address</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-secondary">{{ $contact->ip_address }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">Message</label>
                                <div class="form-control-plaintext border p-3 bg-light">
                                    {{ $contact->message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Additional Information
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">User Agent</label>
                        <div class="form-control-plaintext small text-muted">
                            {{ $contact->user_agent }}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Submitted At</label>
                        <div class="form-control-plaintext">
                            {{ $contact->created_at->format('F d, Y \a\t H:i:s') }}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Last Updated</label>
                        <div class="form-control-plaintext">
                            {{ $contact->updated_at->format('F d, Y \a\t H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Actions
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                            <i class="bx bx-envelope me-2"></i>Reply via Email
                        </a>
                        <a href="tel:{{ $contact->phone_number }}" class="btn btn-success">
                            <i class="bx bx-phone me-2"></i>Call Contact
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Back to List
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this contact submission?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bx bx-trash me-2"></i>Delete Submission
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
