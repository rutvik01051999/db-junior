@extends('admin.layouts.app')

@section('title', 'Edit Guest Of Honour')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Edit Guest Of Honour</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.guest-of-honours.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.guest-of-honours.update', $guestOfHonour->id) }}" method="POST" id="guestOfHonourForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="language" class="form-label fw-bold">Language <span class="text-danger">*</span></label>
                                            <select name="language" id="language" class="form-select form-select-lg @error('language') is-invalid @enderror" required>
                                                <option value="">Select Language</option>
                                                <option value="en" {{ old('language', $guestOfHonour->language) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('language', $guestOfHonour->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
                                            </select>
                                            @error('language')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="season_name" class="form-label fw-bold">Season Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg @error('season_name') is-invalid @enderror" id="season_name" name="season_name" value="{{ old('season_name', $guestOfHonour->season_name) }}" placeholder="Enter season name" required>
                                            @error('season_name')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="guest_name" class="form-label fw-bold">Guest Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg @error('guest_name') is-invalid @enderror" id="guest_name" name="guest_name" value="{{ old('guest_name', $guestOfHonour->guest_name) }}" placeholder="Enter guest name" required>
                                            @error('guest_name')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Settings -->
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $guestOfHonour->status) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this guest of honour</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i> Update Guest Of Honour
                                    </button>
                                    <a href="{{ route('admin.guest-of-honours.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Form validation
        $("#guestOfHonourForm").validate({
            rules: {
                season_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                guest_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
            },
            messages: {
                season_name: {
                    required: "Please enter a season name",
                    minlength: "Season name must be at least 3 characters long",
                    maxlength: "Season name cannot exceed 255 characters"
                },
                guest_name: {
                    required: "Please enter a guest name",
                    minlength: "Guest name must be at least 3 characters long",
                    maxlength: "Guest name cannot exceed 255 characters"
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                // Show loading state
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
                form.submit();
            }
        });
    });
</script>
@endpush
