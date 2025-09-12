@extends('admin.layouts.app')

@section('title', 'Edit Slider')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Edit Slider</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <x-image-upload 
                                            name="image" 
                                            label="Slider Image" 
                                            :required="false"
                                            :current-image="$slider->image"
                                            recommended-size="1920x1080px"
                                        />
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
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $slider->status) ? 'checked' : '' }}>
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
                                        <i class="fas fa-save me-2"></i> Update Slider
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
            if (element.files.length === 0) return true; // No file selected is valid for edit
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, 'File size must be less than {0} KB');

        $.validator.addMethod('extension', function(value, element, param) {
            if (element.files.length === 0) return true; // No file selected is valid for edit
            param = typeof param === "string" ? param.replace(/,/g, '|') : 'png|jpe?g|gif';
            return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
        }, 'Please enter a valid file extension.');

        // Form validation
        $("form").validate({
            rules: {
                image: {
                    extension: "jpg|jpeg|png|gif",
                    filesize: 2048 // 2MB
                }
            },
            messages: {
                image: {
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
                    filesize: "File size must be less than 2MB"
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
