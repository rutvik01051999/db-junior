@props([
    'name' => 'video',
    'label' => 'Video',
    'required' => false,
    'currentVideo' => null,
    'accept' => 'video/*',
    'maxSize' => '100MB',
    'recommendedSize' => '1920x1080px',
    'formats' => 'MP4, MOV, AVI, WMV'
])

<div class="form-group mb-3">
    <label class="form-label fw-bold">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    
    <!-- Hidden file input -->
    <input type="file" 
           name="{{ $name }}" 
           id="{{ $name }}" 
           class="d-none @error($name) is-invalid @enderror" 
           accept="{{ $accept }}" 
           @if($required) required @endif>
    
    @if($currentVideo)
        <!-- Current Video Display -->
        <div class="current-video-section mb-3" id="currentVideoSection">
            <label class="form-label">Current Video:</label>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-video me-2"></i>Current Video</h6>
                </div>
                <div class="card-body text-center">
                    <video width="100%" controls class="rounded shadow" style="max-height: 200px;">
                        <source src="{{ asset('storage/' . $currentVideo) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload Area -->
    <div class="card border-2 border-dashed border-primary">
        <div class="card-body text-center">
            <div class="video-upload-area" id="videoUploadArea">
                <div class="upload-content">
                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                    <h5 class="text-muted">{{ $currentVideo ? 'Click to select new video or drag & drop' : 'Click to select video or drag & drop' }}</h5>
                    <p class="text-muted mb-0">Recommended size: {{ $recommendedSize }}, Max size: {{ $maxSize }}</p>
                    <p class="text-muted">Supported formats: {{ $formats }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- New Video Preview -->
    <div class="video-preview-container d-none" id="videoPreviewContainer">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-video me-2"></i>Selected Video</h6>
                <button type="button" class="btn btn-sm btn-outline-light" id="removeVideoBtn">
                    <i class="fas fa-times"></i> Remove
                </button>
            </div>
            <div class="card-body text-center">
                <video id="videoPreview" controls class="rounded" style="max-width: 100%; max-height: 300px;">
                    Your browser does not support the video tag.
                </video>
                <div class="mt-2">
                    <small class="text-muted" id="videoInfo"></small>
                </div>
            </div>
        </div>
    </div>
    
    @error($name)
        <div class="invalid-feedback d-block mt-2">
            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
        </div>
    @enderror
    
    <!-- Hidden input for remove_current_video removed - no longer needed -->
</div>

@push('styles')
<style>
    /* Video Upload Area Styles */
    .video-upload-area {
        min-height: 150px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .card.border-dashed:hover {
        border-color: #0056b3 !important;
        background: #e3f2fd;
        transform: translateY(-2px);
    }
    
    .card.border-dashed.dragover {
        border-color: #28a745 !important;
        background: #d4edda;
        transform: scale(1.02);
    }
    
    .upload-content {
        pointer-events: none;
    }
    
    .video-upload-area:hover .upload-content i {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    .video-preview-container {
        margin-top: 20px;
    }
    
    .video-preview-container .card {
        border: 2px solid #28a745;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }
    
    .video-preview-container video {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    
    .current-video-section .card {
        border: 2px solid #17a2b8;
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.2);
    }
    
    /* Loading animation */
    .card.upload-loading {
        position: relative;
    }
    
    .card.upload-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 10;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        const fileInput = $('#{{ $name }}');
        const uploadArea = $('#videoUploadArea');
        const uploadCard = uploadArea.closest('.card');
        const previewContainer = $('#videoPreviewContainer');
        const videoPreview = $('#videoPreview');
        const videoInfo = $('#videoInfo');
        const removeBtn = $('#removeVideoBtn');
        
        // Click to upload
        uploadArea.on('click', function() {
            fileInput.click();
        });
        
        // File input change
        fileInput.on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileSelect(file);
            }
        });
        
        // Drag and drop functionality
        uploadCard.on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });
        
        uploadCard.on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });
        
        uploadCard.on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
            
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('video/')) {
                    fileInput[0].files = files;
                    handleFileSelect(file);
                } else {
                    showAlert('Please select a valid video file.', 'error');
                }
            }
        });
        
        // Remove new selected video
        removeBtn.on('click', function() {
            removeSelectedVideo();
        });
        
        // Remove current video functionality removed - no button needed
        
        function handleFileSelect(file) {
            // Validate file type
            if (!file.type.startsWith('video/')) {
                showAlert('Please select a valid video file.', 'error');
                return;
            }
            
            // Validate file size (100MB)
            if (file.size > 100 * 1024 * 1024) {
                showAlert('File size must be less than 100MB.', 'error');
                return;
            }
            
            // Show loading
            uploadCard.addClass('upload-loading');
            
            // Create file URL for preview
            const videoUrl = URL.createObjectURL(file);
            
            // Show preview
            previewContainer.removeClass('d-none');
            
            // Set preview video
            videoPreview.attr('src', videoUrl);
            
            // Set file info
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            videoInfo.text(`${file.name} (${fileSize} MB)`);
            
            // Remove loading
            uploadCard.removeClass('upload-loading');
        }
        
        function removeSelectedVideo() {
            // Clear file input
            fileInput.val('');
            
            // Hide preview
            previewContainer.addClass('d-none');
            
            // Upload area is always visible now, no need to show it
            // Clear preview
            videoPreview.attr('src', '');
            videoInfo.text('');
        }
        
        // removeCurrentVideo function removed - no longer needed
        
        function showAlert(message, type = 'info') {
            alert(message);
        }
    });
</script>
@endpush
