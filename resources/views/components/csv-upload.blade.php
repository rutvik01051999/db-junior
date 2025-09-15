@props([
    'name' => 'csv_file',
    'label' => 'CSV File',
    'required' => false,
    'accept' => '.csv,.txt',
    'maxSize' => '2MB',
    'formats' => 'CSV, TXT'
])

<div class="form-group mb-3">
    <label class="form-label fw-bold">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    
    <!-- Hidden file input -->
    <input type="file" 
           name="{{ $name }}" 
           id="{{ $name }}" 
           class="d-none @error($name) is-invalid @enderror" 
           accept="{{ $accept }}">
    
    <!-- Upload Area -->
    <div class="card border-2 border-dashed border-primary">
        <div class="card-body text-center">
            <div class="csv-upload-area" id="csvUploadArea">
                <div class="upload-content">
                    <i class="fas fa-file-csv fa-3x text-primary mb-3"></i>
                    <h5 class="text-muted">Click to select CSV file or drag & drop</h5>
                    <p class="text-muted mb-0">Max size: {{ $maxSize }}</p>
                    <p class="text-muted">Supported formats: {{ $formats }}</p>
                    <div class="mt-3">
                        <small class="text-info">
                            <strong>CSV Format:</strong> Name, Email, Mobile Number, Created Date
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- File Preview -->
    <div class="file-preview-container d-none" id="filePreviewContainer">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-file-csv me-2"></i>Selected File</h6>
                <button type="button" class="btn btn-sm btn-outline-light" id="removeFileBtn">
                    <i class="fas fa-times"></i> Remove
                </button>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-csv fa-2x text-success me-3"></i>
                    <div>
                        <h6 class="mb-1" id="fileName"></h6>
                        <small class="text-muted" id="fileInfo"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @error($name)
        <div class="invalid-feedback d-block mt-2">
            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
        </div>
    @enderror
</div>

@push('styles')
<style>
    /* CSV Upload Area Styles */
    .csv-upload-area {
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
    
    .csv-upload-area:hover .upload-content i {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    .file-preview-container {
        margin-top: 20px;
    }
    
    .file-preview-container .card {
        border: 2px solid #28a745;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
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
        const uploadArea = $('#csvUploadArea');
        const uploadCard = uploadArea.closest('.card');
        const previewContainer = $('#filePreviewContainer');
        const fileName = $('#fileName');
        const fileInfo = $('#fileInfo');
        const removeBtn = $('#removeFileBtn');
        
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
                if (file.name.toLowerCase().endsWith('.csv') || file.name.toLowerCase().endsWith('.txt')) {
                    fileInput[0].files = files;
                    handleFileSelect(file);
                } else {
                    showAlert('Please select a valid CSV or TXT file.', 'error');
                }
            }
        });
        
        // Remove selected file
        removeBtn.on('click', function() {
            removeSelectedFile();
        });
        
        function handleFileSelect(file) {
            // Validate file type
            if (!file.name.toLowerCase().endsWith('.csv') && !file.name.toLowerCase().endsWith('.txt')) {
                showAlert('Please select a valid CSV or TXT file.', 'error');
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('File size must be less than 2MB.', 'error');
                return;
            }
            
            // Show loading
            uploadCard.addClass('upload-loading');
            
            // Validate CSV content
            const reader = new FileReader();
            reader.onload = function(e) {
                const csvContent = e.target.result;
                const validationResult = validateCSVContent(csvContent);
                
                if (!validationResult.isValid) {
                    showAlert('CSV validation failed: ' + validationResult.errors.join(', '), 'error');
                    uploadCard.removeClass('upload-loading');
                    return;
                }
                
                // Show preview
                previewContainer.removeClass('d-none');
                
                // Set file info
                fileName.text(file.name);
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                fileInfo.text(`${fileSize} MB - ${validationResult.rowCount} rows`);
                
                // Remove loading
                uploadCard.removeClass('upload-loading');
            };
            
            reader.readAsText(file);
        }
        
        function validateCSVContent(csvContent) {
            const lines = csvContent.split('\n').filter(line => line.trim() !== '');
            const errors = [];
            let rowCount = 0;
            
            if (lines.length === 0) {
                errors.push('CSV file is empty');
                return { isValid: false, errors: errors, rowCount: 0 };
            }
            
            for (let i = 0; i < lines.length; i++) {
                const row = lines[i].split(',').map(cell => cell.trim());
                rowCount++;
                
                // Check if row has at least 3 columns (name, email, mobile)
                if (row.length < 3) {
                    errors.push(`Row ${i + 1}: Must have at least Name, Email, and Mobile Number columns`);
                    continue;
                }
                
                const name = row[0];
                const email = row[1] || '';
                const mobile = row[2];
                const date = row[3] || '';
                
                // Validate name
                if (!name || name === '') {
                    errors.push(`Row ${i + 1}: Name is required`);
                } else if (name.length < 2 || name.length > 100) {
                    errors.push(`Row ${i + 1}: Name must be between 2 and 100 characters`);
                } else if (!/^[a-zA-Z\s\.\-\']+$/.test(name)) {
                    errors.push(`Row ${i + 1}: Name should contain only letters, spaces, dots, hyphens, and apostrophes`);
                }
                
                // Validate mobile number
                if (!mobile || mobile === '') {
                    errors.push(`Row ${i + 1}: Mobile number is required`);
                } else if (!/^[6-9]\d{9}$/.test(mobile)) {
                    errors.push(`Row ${i + 1}: Mobile number must be a valid 10-digit number starting with 6, 7, 8, or 9`);
                }
                
                // Validate email if provided
                if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push(`Row ${i + 1}: Invalid email format`);
                }
                
                
                // Validate date if provided
                if (date && !/^\d{4}-\d{2}-\d{2}$/.test(date)) {
                    errors.push(`Row ${i + 1}: Date must be in YYYY-MM-DD format`);
                }
            }
            
            return {
                isValid: errors.length === 0,
                errors: errors,
                rowCount: rowCount
            };
        }
        
        function removeSelectedFile() {
            // Clear file input
            fileInput.val('');
            
            // Hide preview
            previewContainer.addClass('d-none');
            
            // Clear preview
            fileName.text('');
            fileInfo.text('');
        }
        
        function showAlert(message, type = 'info') {
            // Use the main showAlert function if it exists, otherwise use alert
            if (typeof window.showAlert === 'function') {
                window.showAlert(type, message);
            } else {
                alert(message);
            }
        }
    });
</script>
@endpush
