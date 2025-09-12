@extends('admin.layouts.app')

@section('title', 'Create Slider')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Create New Slider</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" id="create-slider-form">
                        @csrf

                        
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <x-image-upload 
                                            name="image" 
                                            label="Slider Image" 
                                            :required="true"
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Save Slider
                                    </button>
                                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
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
        $("#create-slider-form").validate({
            rules: {
                image: {
                    required: true
                }
            },
            messages: {
                image: {
                    required: "Please select a slider image"
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
