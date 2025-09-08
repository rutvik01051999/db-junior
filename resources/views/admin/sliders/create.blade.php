@extends('admin.layouts.app')

@section('title', 'Create Slider')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Slider</h4>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" id="create-slider-form">
                        @csrf

                        
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="image" class="form-label fw-bold">Slider Image <span class="text-danger">*</span></label>
                                            <div class="card border-2 border-dashed border-primary">
                                                <div class="card-body text-center">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" required>
                                                        <label class="custom-file-label btn btn-outline-primary" for="image">
                                                            <i class="fas fa-cloud-upload-alt me-2"></i>Choose Image File
                                                        </label>
                                                        @error('image')
                                                            <div class="invalid-feedback">
                                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <small class="form-text text-muted mt-2 d-block">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Recommended size: 1920x1080px or similar aspect ratio
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
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this slider</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i> Save Slider
                                    </button>
                                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary btn-lg">
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
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, 'File size must be less than {0} KB');

        $.validator.addMethod('extension', function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : 'png|jpe?g|gif';
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
        }, 'Please enter a valid file extension.');

        // Form validation
        $("#create-slider-form").validate({
            rules: {
                image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif",
                    filesize: 2048 // 2MB
                },
                status: {
                    required: true
                }
            },
            messages: {
                image: {
                    required: "Please select a slider image",
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
                    filesize: "File size must be less than 2MB"
                },
                status: {
                    required: "Please set the slider status"
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
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                form.submit();
            }
        });
    });
</script>
@endpush
