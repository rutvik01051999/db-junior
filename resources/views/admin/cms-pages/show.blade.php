@extends('admin.layouts.app')

@section('title', 'View CMS Page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">View CMS Page</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.cms-pages.edit', $cmsPage->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-4">
                                <h2 class="text-primary">{{ $cmsPage->title }}</h2>
                                <p class="text-muted">
                                    <i class="fas fa-link me-1"></i>Slug: <code>{{ $cmsPage->slug }}</code>
                                </p>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">Content:</h5>
                                <div class="border p-3 rounded bg-light">
                                    {!! $cmsPage->content !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card bg-light">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Page Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge badge-{{ $cmsPage->is_active ? 'success' : 'danger' }}">
                                            {{ $cmsPage->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Created:</strong><br>
                                        <small class="text-muted">{{ $cmsPage->created_at->format('M d, Y \a\t h:i A') }}</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Last Updated:</strong><br>
                                        <small class="text-muted">{{ $cmsPage->updated_at->format('M d, Y \a\t h:i A') }}</small>
                                    </div>
                                </div>
                            </div>

                            @if($cmsPage->meta_title || $cmsPage->meta_description)
                            <div class="card bg-light mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Information</h6>
                                </div>
                                <div class="card-body">
                                    @if($cmsPage->meta_title)
                                    <div class="mb-3">
                                        <strong>Meta Title:</strong><br>
                                        <small class="text-muted">{{ $cmsPage->meta_title }}</small>
                                    </div>
                                    @endif
                                    
                                    @if($cmsPage->meta_description)
                                    <div class="mb-3">
                                        <strong>Meta Description:</strong><br>
                                        <small class="text-muted">{{ $cmsPage->meta_description }}</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.cms-pages.edit', $cmsPage->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Page
                    </a>
                    <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
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
    
    .badge-success {
        background-color: #28a745;
    }
    
    .badge-danger {
        background-color: #dc3545;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
@endpush
