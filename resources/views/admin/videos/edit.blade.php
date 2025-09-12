@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Edit Video</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="videoForm" action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $video->title) }}" placeholder="Enter video title" required>
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Video Upload Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="video" class="form-label fw-bold">Video File</label>
                                            
                                            <!-- Current Video Display -->
                                            <div class="card mb-3">
                                                <div class="card-header bg-info text-white">
                                                    <h6 class="mb-0"><i class="fas fa-video me-2"></i>Current Video</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <video width="100%" controls class="rounded shadow">
                                                        <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </div>

                                            <!-- New Video Upload -->
                                            <div class="card border-2 border-dashed border-primary">
                                                <div class="card-body text-center">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('video') is-invalid @enderror" id="video" name="video" accept="video/*">
                                                        {{-- <label class="custom-file-label btn btn-outline-primary" for="video">
                                                            <i class="fas fa-video me-2"></i>Choose New Video File
                                                        </label> --}}
                                                        @error('video')
                                                            <div class="invalid-feedback">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <small class="form-text text-muted mt-2 d-block">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Leave empty to keep current video. Max: 100MB, Supported formats: MP4, MOV, AVI, WMV
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <video id="videoPreview" controls class="d-none rounded shadow" style="max-width: 100%; max-height: 300px;">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
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
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this video</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Update Video
                                    </button>
                                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
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
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Show file name in custom file input
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            
            // Preview video
            const file = this.files[0];
            if (file) {
                const videoPreview = document.getElementById('videoPreview');
                const videoUrl = URL.createObjectURL(file);
                videoPreview.src = videoUrl;
                videoPreview.classList.remove('d-none');
            }
        });

        // Custom validation methods
        $.validator.addMethod('filesize', function(value, element, param) {
            if (element.files.length === 0) return true; // No file selected is valid for edit
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, 'File size must be less than {0} KB');

        $.validator.addMethod('videoExtension', function(value, element, param) {
            if (element.files.length === 0) return true; // No file selected is valid for edit
            param = typeof param === "string" ? param.replace(/,/g, '|') : 'mp4|mov|avi|wmv';
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
        }, 'Please enter a valid video file extension.');

        // Form validation
        $("#videoForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                video: {
                    videoExtension: "mp4|mov|avi|wmv",
                    filesize: 102400 // 100MB
                },
                is_active: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a video title",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title must not exceed 255 characters"
                },
                video: {
                    videoExtension: "Please select a valid video file (MP4, MOV, AVI, WMV)",
                    filesize: "File size must be less than 100MB"
                },
                is_active: {
                    required: "Please set the video status"
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
@endsection
