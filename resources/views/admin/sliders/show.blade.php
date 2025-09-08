@extends('admin.layouts.app')

@section('title', 'View Slider')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Slider Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($slider->image)
                                <img src="{{ $slider->image_url }}" alt="Slider Image" class="img-fluid rounded">
                            @else
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-image fa-5x text-muted mb-3"></i>
                                    <p class="mb-0">No Image Available</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Status</th>
                                    <td>
                                        <span class="badge {{ $slider->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $slider->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $slider->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $slider->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
