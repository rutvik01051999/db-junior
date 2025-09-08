@extends('admin.layouts.app')

@section('title', 'View Process')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Process Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.processes.edit', $process->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.processes.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($process->image)
                                <img src="{{ $process->image_url }}" alt="{{ $process->title }}" class="img-fluid rounded">
                            @else
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-image fa-5x text-muted mb-3"></i>
                                    <p class="mb-0">No Image Available</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Title</th>
                                    <td>{{ $process->title }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $process->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $process->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $process->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $process->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($process->steps->count() > 0)
                        <div class="mt-4">
                            <h5>Process Steps</h5>
                            <div class="row">
                                @foreach($process->steps as $index => $step)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                                    {{ $step->sub_title }}
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">{!! nl2br(e($step->description)) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
