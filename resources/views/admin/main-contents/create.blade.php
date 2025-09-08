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
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Participation Categories -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Participation Categories</h6>
                                    </div>
                                    <div class="card-body">
                                        @for($i = 1; $i <= 4; $i++)
                                            @php
                                                $fieldName = 'participation_categories_' . $i;
                                            @endphp
                                            <div class="form-group">
                                                <label for="{{ $fieldName }}">Category {{ $i }}</label>
                                                <input type="text" name="{{ $fieldName }}" 
                                                       id="{{ $fieldName }}" 
                                                       class="form-control @error($fieldName) is-invalid @enderror" 
                                                       value="{{ old($fieldName) }}">
                                                @error($fieldName)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Timeline -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Timeline</h6>
                                    </div>
                                    <div class="card-body">
                                        @for($i = 1; $i <= 4; $i++)
                                            @php
                                                $fieldName = 'timeline_' . $i;
                                            @endphp
                                            <div class="form-group">
                                                <label for="{{ $fieldName }}">Timeline {{ $i }}</label>
                                                <input type="text" name="{{ $fieldName }}" 
                                                       id="{{ $fieldName }}" 
                                                       class="form-control @error($fieldName) is-invalid @enderror" 
                                                       value="{{ old($fieldName) }}">
                                                @error($fieldName)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Width Row for Image Upload -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Image <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" required>
                                        <label class="custom-file-label" for="image">Choose file</label>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Recommended size: 1200x600px, Max size: 2MB</small>
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px;">
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

        // Show file name in custom file input
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            
            // Show image preview
            readURL(this);
        });

        // Form validation
        $("#mainContentForm").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 255
                },
                image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                },
                sort_order: {
                    number: true,
                    min: 0
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    maxlength: "Title should not be more than 255 characters"
                },
                image: {
                    required: "Please select an image",
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
                },
                sort_order: {
                    number: "Please enter a valid number",
                    min: "Sort order cannot be negative"
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
