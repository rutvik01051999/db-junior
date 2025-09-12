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
                    
                    <div class="certificate-content">
                        <p class="mb-4">This is to certify that</p>
                        
                        <h2 class="mb-4 text-dark fw-bold">
                            {{ $student->name ?? 'N/A' }}
                        </h2>
                        
                        <p class="mb-4">has successfully participated in</p>
                        
                        <h3 class="mb-4 text-primary">Junior Editor Program 2024</h3>
                        
                        <p class="mb-4">organized by Dainik Bhaskar Group</p>
                        
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Mobile Number:</strong></p>
                                <p>{{ $student->mobile_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Registration Date:</strong></p>
                                <p>{{ $student->created_date ? date('d M Y', strtotime($student->created_date)) : 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <p class="text-muted">Certificate ID: JE{{ $student->id ?? 'N/A' }}{{ date('Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
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

.certificate-content {
    border: 2px dashed #007bff;
    padding: 30px;
    margin: 20px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>
@endsection
