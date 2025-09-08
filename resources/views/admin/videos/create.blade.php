@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Video</h4>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form id="videoForm" action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="video">Video File <span class="text-danger">*</span> <small class="text-muted">(Max: 100MB, Supported formats: MP4, MOV, AVI, WMV)</small></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('video') is-invalid @enderror" id="video" name="video" accept="video/*" required>
                                <label class="custom-file-label" for="video">Choose video file</label>
                                @error('video')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <video id="videoPreview" controls class="d-none" style="max-width: 100%; max-height: 300px;">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Video
                            </button>
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

        // Form validation
        $("#videoForm").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 255
                },
                video: {
                    required: true,
                    accept: "video/*"
                },
                sort_order: {
                    min: 0
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    maxlength: "Title must not exceed 255 characters"
                },
                video: {
                    required: "Please select a video file",
                    accept: "Please select a valid video file (MP4, MOV, AVI, WMV)"
                },
                sort_order: {
                    min: "Sort order must be a positive number"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
@endsection
