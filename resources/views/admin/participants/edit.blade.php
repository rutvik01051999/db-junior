@extends('admin.layouts.app')

@section('title', 'Edit Participant')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Participant</h4>
                    <a href="{{ route('admin.participants.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.participants.update', $participant->id) }}" method="POST" id="participantForm">
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
                                                <option value="en" {{ old('language', $participant->language) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('language', $participant->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
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
                                            <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $participant->title) }}" placeholder="Enter participant title" required>
                                            @error('title')
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
                                            <label for="number_of_participants" class="form-label fw-bold">Number of Participants <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control form-control-lg @error('number_of_participants') is-invalid @enderror" id="number_of_participants" name="number_of_participants" value="{{ old('number_of_participants', $participant->number_of_participants) }}" min="1" placeholder="Enter number of participants" required>
                                            @error('number_of_participants')
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
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $participant->status) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this participant</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i> Update Participant
                                    </button>
                                    <a href="{{ route('admin.participants.index') }}" class="btn btn-secondary btn-lg">
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
        $("#participantForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                number_of_participants: {
                    required: true,
                    min: 1,
                    max: 999999
                },
            },
            messages: {
                title: {
                    required: "Please enter a participant title",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title cannot exceed 255 characters"
                },
                number_of_participants: {
                    required: "Please enter the number of participants",
                    min: "Number of participants must be at least 1",
                    max: "Number of participants cannot exceed 999,999"
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
