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
                                            <label for="language" class="form-label fw-bold">Language <span class="text-danger">*</span></label>
                                            <select name="language" id="language" class="form-select form-select-lg @error('language') is-invalid @enderror" required>
                                                <option value="">Select Language</option>
                                                <option value="en" {{ old('language', $bannerSection->language) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('language', $bannerSection->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
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
                                        <x-image-upload 
                                            name="image" 
                                            label="Banner Image" 
                                            :required="false"
                                            :current-image="$bannerSection->image"
                                            recommended-size="1920x600px"
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

@push('styles')
<style>
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    
    .form-label {
        color: #495057;
        font-weight: 600;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
$(document).ready(function() {
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'blockQuote', '|',
                    'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .then(editor => {
            window.descriptionEditor = editor;
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });

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
                minlength: 10
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
                minlength: "Description must be at least 10 characters long"
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
            // Update textarea with CKEditor content before submit
            if (window.descriptionEditor) {
                window.descriptionEditor.updateSourceElement();
            }
            
            // Show loading state
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
            form.submit();
        }
    });
});
</script>
@endpush
