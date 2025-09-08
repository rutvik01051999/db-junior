@extends('admin.layouts.app')

@section('title', 'Create Process')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Process</h4>
                    <a href="{{ route('admin.processes.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.processes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Process Steps <span class="text-danger">*</span></label>
                            <div id="steps-container">
                                <div class="step-item border p-3 mb-3 rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Sub Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('steps.0.sub_title') is-invalid @enderror" name="steps[0][sub_title]" value="{{ old('steps.0.sub_title') }}" required>
                                        @error('steps.0.sub_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('steps.0.description') is-invalid @enderror" name="steps[0][description]" rows="3" required>{{ old('steps.0.description') }}</textarea>
                                        @error('steps.0.description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-danger remove-step" style="display: none;">
                                            <i class="fas fa-trash"></i> Remove Step
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="add-step">
                                <i class="fas fa-plus"></i> Add Step
                            </button>
                            @error('steps')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 800x600px</small>
                        </div>


                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Process
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    let stepIndex = 1;
    
    // Add step functionality
    document.getElementById('add-step').addEventListener('click', function() {
        const container = document.getElementById('steps-container');
        const newStep = document.createElement('div');
        newStep.className = 'step-item border p-3 mb-3 rounded';
        newStep.innerHTML = `
            <div class="mb-3">
                <label class="form-label">Sub Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="steps[${stepIndex}][sub_title]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="steps[${stepIndex}][description]" rows="3" required></textarea>
            </div>
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-danger remove-step">
                    <i class="fas fa-trash"></i> Remove Step
                </button>
            </div>
        `;
        container.appendChild(newStep);
        stepIndex++;
        updateRemoveButtons();
    });
    
    // Remove step functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-step')) {
            e.target.closest('.step-item').remove();
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
});
</script>
@endpush
