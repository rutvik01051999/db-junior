@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Banner</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.banner-sections.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.banner-sections.update', $bannerSection->id) }}" method="POST" enctype="multipart/form-data" id="bannerForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $bannerSection->title) }}" placeholder="Enter banner title" required>
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
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Enter banner description">{{ old('description', $bannerSection->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="image" class="form-label fw-bold">Banner Image</label>
                                            
                                            <!-- Current Image Display -->
                                            @if($bannerSection->image)
                                                <div class="card mb-3">
                                                    <div class="card-header bg-info text-white">
                                                        <h6 class="mb-0"><i class="fas fa-image me-2"></i>Current Image</h6>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('storage/' . $bannerSection->image) }}" alt="Current Banner" class="img-fluid rounded shadow" style="max-height: 200px;">
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- New Image Upload -->
                                            <div class="card border-2 border-dashed border-primary">
                                                <div class="card-body text-center">
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
                                                        <label class="custom-file-label btn btn-outline-primary" for="image">
                                                            <i class="fas fa-cloud-upload-alt me-2"></i>Choose New Image File
                                                        </label>
                                                        @error('image')
                                                            <div class="invalid-feedback">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <small class="form-text text-muted mt-2 d-block">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Leave empty to keep current image. Recommended size: 1920x600px, Max size: 2MB
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded shadow" style="max-height: 200px; display: none;">
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
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $bannerSection->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this banner</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Banner
                        </button>
                        <a href="{{ route('admin.banner-sections.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Preview image before upload
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image").change(function() {
                readURL(this);
            });

            // Custom validation methods
            $.validator.addMethod('filesize', function(value, element, param) {
                if (element.files.length === 0) return true; // No file selected is valid for edit
                return this.optional(element) || (element.files[0].size <= param * 1024);
            }, 'File size must be less than {0} KB');

            $.validator.addMethod('extension', function(value, element, param) {
                if (element.files.length === 0) return true; // No file selected is valid for edit
                param = typeof param === "string" ? param.replace(/,/g, '|') : 'png|jpe?g|gif';
                return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
            }, 'Please enter a valid file extension.');

            // Form validation
            $("#bannerForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    description: {
                        required: true,
                        minlength: 10,
                        maxlength: 1000
                    },
                    image: {
                        extension: "jpg|jpeg|png|gif",
                        filesize: 2048 // 2MB
                    },
                    is_active: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a banner title",
                        minlength: "Title must be at least 3 characters long",
                        maxlength: "Title cannot exceed 255 characters"
                    },
                    description: {
                        required: "Please enter a banner description",
                        minlength: "Description must be at least 10 characters long",
                        maxlength: "Description cannot exceed 1000 characters"
                    },
                    image: {
                        extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
                        filesize: "File size must be less than 2MB"
                    },
                    is_active: {
                        required: "Please set the banner status"
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

            // Show filename in file input
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName || "Choose file");
            });
        });
    </script>
@endpush
