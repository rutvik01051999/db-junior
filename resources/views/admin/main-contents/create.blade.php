@extends('admin.layouts.app')

@section('title', 'Add New Main Content')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Main Content</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.main-contents.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.main-contents.store') }}" method="POST" enctype="multipart/form-data" id="mainContentForm">
                    @csrf
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
                                                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('language') == 'hi' ? 'selected' : '' }}>Hindi</option>
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
                                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter main content title" required>
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
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Enter main content description">{{ old('description') }}</textarea>
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
                                            label="Image" 
                                            :required="true"
                                            recommended-size="1200x600px"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Additional Fields -->
                            <div class="col-lg-4">
                                <!-- Participation Categories -->
                                <div class="card mb-3">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-users me-2"></i>Participation Categories</h6>
                                    </div>
                                    <div class="card-body">
                                        @for($i = 1; $i <= 4; $i++)
                                            @php
                                                $fieldName = 'participation_categories_' . $i;
                                            @endphp
                                            <div class="form-group mb-3">
                                                <label for="{{ $fieldName }}" class="form-label">Category {{ $i }}</label>
                                                <input type="text" name="{{ $fieldName }}" 
                                                       id="{{ $fieldName }}" 
                                                       class="form-control @error($fieldName) is-invalid @enderror" 
                                                       value="{{ old($fieldName) }}"
                                                       placeholder="Enter category {{ $i }}">
                                                @error($fieldName)
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Timeline -->
                                <div class="card mb-3">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Timeline</h6>
                                    </div>
                                    <div class="card-body">
                                        @for($i = 1; $i <= 4; $i++)
                                            @php
                                                $fieldName = 'timeline_' . $i;
                                            @endphp
                                            <div class="form-group mb-3">
                                                <label for="{{ $fieldName }}" class="form-label">Timeline {{ $i }}</label>
                                                <input type="text" name="{{ $fieldName }}" 
                                                       id="{{ $fieldName }}" 
                                                       class="form-control @error($fieldName) is-invalid @enderror" 
                                                       value="{{ old($fieldName) }}"
                                                       placeholder="Enter timeline {{ $i }}">
                                                @error($fieldName)
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Status Settings -->
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
                                            <small class="form-text text-muted">Toggle to enable/disable this content</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('admin.main-contents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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

        // Show file name in custom file input
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            
            // Show image preview
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
        $("#mainContentForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                description: {
                    required: true,
                    minlength: 10
                },
                image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif",
                    filesize: 2048 // 2MB
                },
                participation_categories_1: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                participation_categories_2: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                participation_categories_3: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                participation_categories_4: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                timeline_1: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                timeline_2: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                timeline_3: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                timeline_4: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                is_active: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title should not be more than 255 characters"
                },
                description: {
                    required: "Please enter a description",
                    minlength: "Description must be at least 10 characters long"
                },
                image: {
                    required: "Please select an image",
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
                    filesize: "File size must be less than 2MB"
                },
                participation_categories_1: {
                    required: "Please enter participation category 1",
                    minlength: "Category must be at least 2 characters long",
                    maxlength: "Category cannot exceed 100 characters"
                },
                participation_categories_2: {
                    required: "Please enter participation category 2",
                    minlength: "Category must be at least 2 characters long",
                    maxlength: "Category cannot exceed 100 characters"
                },
                participation_categories_3: {
                    required: "Please enter participation category 3",
                    minlength: "Category must be at least 2 characters long",
                    maxlength: "Category cannot exceed 100 characters"
                },
                participation_categories_4: {
                    required: "Please enter participation category 4",
                    minlength: "Category must be at least 2 characters long",
                    maxlength: "Category cannot exceed 100 characters"
                },
                timeline_1: {
                    required: "Please enter timeline 1",
                    minlength: "Timeline must be at least 2 characters long",
                    maxlength: "Timeline cannot exceed 100 characters"
                },
                timeline_2: {
                    required: "Please enter timeline 2",
                    minlength: "Timeline must be at least 2 characters long",
                    maxlength: "Timeline cannot exceed 100 characters"
                },
                timeline_3: {
                    required: "Please enter timeline 3",
                    minlength: "Timeline must be at least 2 characters long",
                    maxlength: "Timeline cannot exceed 100 characters"
                },
                timeline_4: {
                    required: "Please enter timeline 4",
                    minlength: "Timeline must be at least 2 characters long",
                    maxlength: "Timeline cannot exceed 100 characters"
                },
                is_active: {
                    required: "Please set the content status"
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
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                form.submit();
            }
        });
    });
</script>
@endpush
