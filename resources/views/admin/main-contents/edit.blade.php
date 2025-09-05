@extends('admin.layouts.app')

@section('title', 'Edit Main Content')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Main Content</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.main-contents.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.main-contents.update', $mainContent->id) }}" method="POST" enctype="multipart/form-data" id="mainContentForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $mainContent->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $mainContent->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="participation_categories">Participation Categories</label>
                                    <input type="text" name="participation_categories" id="participation_categories" class="form-control @error('participation_categories') is-invalid @enderror" value="{{ old('participation_categories', $mainContent->participation_categories) }}">
                                    @error('participation_categories')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="timeline">Timeline</label>
                                    <input type="text" name="timeline" id="timeline" class="form-control @error('timeline') is-invalid @enderror" value="{{ old('timeline', $mainContent->timeline) }}">
                                    @error('timeline')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $mainContent->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Width Row for Image Upload -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Image @if(!$mainContent->image)<span class="text-danger">*</span>@endif</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" {{ !$mainContent->image ? 'required' : '' }}>
                                        <label class="custom-file-label" for="image">Choose file</label>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Leave empty to keep the current image. Recommended size: 1200x600px, Max size: 2MB</small>
                                    @if($mainContent->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $mainContent->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            <p class="text-muted mt-1">Current Image</p>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="New Image Preview" style="display: none; max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
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

        // Show current image if exists
        @if($mainContent->image)
            $('#imagePreview').attr('src', '{{ asset('storage/' . $mainContent->image) }}').show();
        @endif

        // Form validation
        $("#mainContentForm").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 255
                },
                image: {
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
