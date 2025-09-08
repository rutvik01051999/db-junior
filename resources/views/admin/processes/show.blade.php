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
                                @if($process->sub_title)
                                    <tr>
                                        <th>Sub Title</th>
                                        <td>{{ $process->sub_title }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $process->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $process->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                @if($process->description)
                                    <tr>
                                        <th>Description</th>
                                        <td>{!! nl2br(e($process->description)) !!}</td>
                                    </tr>
                                @endif
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
                </div>
            </div>
        </div>
    </div>
@endsection
