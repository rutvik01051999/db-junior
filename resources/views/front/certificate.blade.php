@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5 text-center">
                    <h1 class="mb-4 text-primary">
                        <i class="fas fa-certificate me-3"></i>
                        Certificate of Participation
                    </h1>
                    
                    <div class="certificate-preview">
                        <div class="certificate-image-wrapper">
                            <img src="{{ asset('front/assets/img/certificate/certificate.jpg') }}" alt="Certificate Preview" class="certificate-preview-image">
                            <div class="student-name-preview">
                                {{ $student->name ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="certificate-info mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Mobile Number:</strong></p>
                                    <p>{{ $student->mobile_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Registration Date:</strong></p>
                                    <p>{{ $student->created_date ? date('d M Y', strtotime($student->created_date)) : 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-muted">Certificate ID: JE{{ $student->id ?? 'N/A' }}{{ date('Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button onclick="downloadCertificate()" class="btn btn-success me-3">
                            <i class="fas fa-download me-2"></i>Download Certificate
                        </button>
                        <button onclick="window.print()" class="btn btn-primary me-3">
                            <i class="fas fa-print me-2"></i>Print Certificate
                        </button>
                        <a href="{{ route('certificate.get') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .mt-4 {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 2px solid #000 !important;
    }
    
    .certificate-content {
        border: 3px solid #007bff;
        padding: 30px;
        margin: 20px 0;
    }
}

.certificate-preview {
    text-align: center;
}

.certificate-image-wrapper {
    position: relative;
    display: inline-block;
    max-width: 100%;
}

.certificate-preview-image {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.student-name-preview {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #2c3e50;
    font-size: 24px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);
    letter-spacing: 1px;
    text-transform: uppercase;
    max-width: 80%;
    word-wrap: break-word;
}

.certificate-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
}
</style>

<script>
function downloadCertificate() {
    // Get the mobile number from the URL or pass it as a parameter
    const urlParams = new URLSearchParams(window.location.search);
    const mobile = urlParams.get('mobile');
    
    if (!mobile) {
        alert('Mobile number not found. Please try again.');
        return;
    }
    
    // Show loading state
    const downloadBtn = event.target;
    const originalText = downloadBtn.innerHTML;
    downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Downloading...';
    downloadBtn.disabled = true;
    
    // Create a form to submit the download request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("certificate.download-pdf") }}';
    form.target = '_blank';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Add mobile number
    const mobileInput = document.createElement('input');
    mobileInput.type = 'hidden';
    mobileInput.name = 'mobile';
    mobileInput.value = mobile;
    form.appendChild(mobileInput);
    
    // Add form to document and submit
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Reset button state after a delay
    setTimeout(() => {
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;
    }, 3000);
}
</script>
@endsection
