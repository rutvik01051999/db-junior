@extends('admin.layouts.app')

@section('title', 'Edit Process')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Edit Process</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.processes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.processes.update', $process->id) }}" method="POST" enctype="multipart/form-data" id="processForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                            <select name="language" id="language" class="form-select @error('language') is-invalid @enderror" required>
                                <option value="">Select Language</option>
                                <option value="en" {{ old('language', $process->language) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="hi" {{ old('language', $process->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $process->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Process Steps <span class="text-danger">*</span></label>
                            <div id="steps-container">
                                @if($process->steps->count() > 0)
                                    @foreach($process->steps as $index => $step)
                                        <div class="step-item border p-3 mb-3 rounded">
                                            <input type="hidden" name="steps[{{ $index }}][id]" value="{{ $step->id }}">
                                            <div class="mb-3">
                                                <label class="form-label">Step Content <span class="text-danger">*</span></label>
                                                <textarea class="form-control step-content @error('steps.'.$index.'.content') is-invalid @enderror" name="steps[{{ $index }}][content]" rows="6" required>{{ old('steps.'.$index.'.content', $step->content) }}</textarea>
                                                @error('steps.'.$index.'.content')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Use the rich text editor to format your step content with headings, lists, and other formatting.</small>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-step" {{ $process->steps->count() <= 1 ? 'style=display:none' : '' }}>
                                                    <i class="fas fa-trash"></i> Remove Step
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="step-item border p-3 mb-3 rounded">
                                        <div class="mb-3">
                                            <label class="form-label">Step Content <span class="text-danger">*</span></label>
                                            <textarea class="form-control step-content @error('steps.0.content') is-invalid @enderror" name="steps[0][content]" rows="6" required>{{ old('steps.0.content') }}</textarea>
                                            @error('steps.0.content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Use the rich text editor to format your step content with headings, lists, and other formatting.</small>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger remove-step" style="display: none;">
                                                <i class="fas fa-trash"></i> Remove Step
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @error('steps')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-image-upload 
                            name="image" 
                            label="Image" 
                            :required="false"
                            :current-image="$process->image"
                            recommended-size="800x600px"
                        />


                        <div class="mb-3">
                            <div class="card bg-light">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Settings</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $process->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">Active</label>
                                        </div>
                                        <small class="form-text text-muted">Toggle to enable/disable this process</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Process
                            </button>
                            <a href="{{ route('admin.processes.index') }}" class="btn btn-light">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let editors = {}; // Store CKEditor instances
    
    // Initialize CKEditor for existing textareas
    function initializeCKEditor(textarea) {
        const name = textarea.name;
        ClassicEditor
            .create(textarea, {
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
                editors[name] = editor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    }
    
    // Initialize CKEditor for existing textareas
    document.querySelectorAll('.step-content').forEach(initializeCKEditor);
    
    
    // Remove step functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-step')) {
            const stepItem = e.target.closest('.step-item');
            const textarea = stepItem.querySelector('.step-content');
            
            // Destroy CKEditor instance if it exists
            if (textarea && editors[textarea.name]) {
                editors[textarea.name].destroy();
                delete editors[textarea.name];
            }
            
            stepItem.remove();
            updateRemoveButtons();
        }
    });
    
    // Update remove buttons visibility
    function updateRemoveButtons() {
        const stepItems = document.querySelectorAll('.step-item');
        const removeButtons = document.querySelectorAll('.remove-step');
        
        removeButtons.forEach((button, index) => {
            if (stepItems.length > 1) {
                button.style.display = 'inline-block';
            } else {
                button.style.display = 'none';
            }
        });
    }
    
    // Initialize
    updateRemoveButtons();
    
    // Custom validation methods
    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param * 1024);
    }, 'File size must be less than {0} KB');

    $.validator.addMethod('extension', function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : 'png|jpe?g|gif';
        return this.optional(element) || value.match(new RegExp('\\.(' + param + ')$', 'i'));
    }, 'Please enter a valid file extension.');

    // jQuery Form Validation
    $("#processForm").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            image: {
                extension: "jpg|jpeg|png|gif|webp",
                filesize: 2048 // 2MB
            }
        },
        messages: {
            title: {
                required: "Please enter a process title",
                minlength: "Title must be at least 3 characters long",
                maxlength: "Title cannot exceed 255 characters"
            },
            image: {
                extension: "Please upload a valid image file (jpg, jpeg, png, gif, webp)",
                filesize: "File size must be less than 2MB"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.attr('name') === 'image') {
                element.closest('.form-group').append(error);
            } else {
                element.closest('.mb-3').append(error);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            // Update all CKEditor instances before validation
            Object.values(editors).forEach(editor => {
                editor.updateSourceElement();
            });
            
            // Validate process steps
            let isValid = true;
            const stepItems = document.querySelectorAll('.step-item');
            
            stepItems.forEach((step, index) => {
                const content = step.querySelector('textarea[name*="[content]"]');
                
                // Validate content (required)
                if (!content.value.trim()) {
                    isValid = false;
                    $(content).addClass('is-invalid');
                    if (!step.querySelector('.invalid-feedback')) {
                        $(content).after('<div class="invalid-feedback">Step content is required for step ' + (index + 1) + '</div>');
                    }
                } else if (content.value.trim().length < 10) {
                    isValid = false;
                    $(content).addClass('is-invalid');
                    if (!step.querySelector('.invalid-feedback')) {
                        $(content).after('<div class="invalid-feedback">Step content must be at least 10 characters long for step ' + (index + 1) + '</div>');
                    }
                } else {
                    $(content).removeClass('is-invalid');
                    step.querySelectorAll('.invalid-feedback').forEach(feedback => {
                        if (feedback.textContent.includes('Step content')) {
                            feedback.remove();
                        }
                    });
                }
            });
            
            if (!isValid) {
                return false;
            }
            
            // Show loading state
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
            form.submit();
        }
    });
});
</script>
@endpush
