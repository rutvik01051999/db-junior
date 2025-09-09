@extends('admin.layouts.app')

@section('title', 'Create CMS Page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New CMS Page</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.cms-pages.store') }}" method="POST" id="cmsPageForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter page title" required>
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
                                            <label for="content" class="form-label fw-bold">Page Content <span class="text-danger">*</span></label>
                                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="15" placeholder="Enter page content" required>{{ old('content') }}</textarea>
                                            @error('content')
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
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to enable/disable this page</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-light mt-3">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Settings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" placeholder="Enter meta title">
                                            @error('meta_title')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="form-text text-muted">Recommended: 50-60 characters</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                                            <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="3" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="form-text text-muted">Recommended: 150-160 characters</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Page
                        </button>
                        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary">
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'blockQuote', 'insertTable', '|',
                        'link', 'imageUpload', '|',
                        'undo', 'redo'
                    ]
                },
                language: 'en',
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Form validation
        $("#cmsPageForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                content: {
                    required: true,
                    minlength: 10
                },
                meta_title: {
                    maxlength: 255
                },
                meta_description: {
                    maxlength: 500
                }
            },
            messages: {
                title: {
                    required: "Please enter a page title",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title cannot exceed 255 characters"
                },
                content: {
                    required: "Please enter page content",
                    minlength: "Content must be at least 10 characters long"
                },
                meta_title: {
                    maxlength: "Meta title cannot exceed 255 characters"
                },
                meta_description: {
                    maxlength: "Meta description cannot exceed 500 characters"
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
                if (window.editor) {
                    window.editor.updateSourceElement();
                }
                
                // Show loading state
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                form.submit();
            }
        });
    });
</script>
@endpush
