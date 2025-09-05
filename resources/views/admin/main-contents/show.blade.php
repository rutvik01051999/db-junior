@extends('admin.layouts.app')

@section('title', 'View Main Content')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Main Content Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.main-contents.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="200">Title</th>
                                    <td>{{ $mainContent->title }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!! $mainContent->description ? nl2br(e($mainContent->description)) : '<span class="text-muted">No description</span>' !!}</td>
                                </tr>
                                <tr>
                                    <th>Participation Categories</th>
                                    <td>{{ $mainContent->participation_categories ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Timeline</th>
                                    <td>{{ $mainContent->timeline ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $mainContent->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $mainContent->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $mainContent->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $mainContent->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $mainContent->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-image"></i> Image Preview
                                    </h3>
                                </div>
                                <div class="card-body text-center">
                                    @if($mainContent->image)
                                        <img src="{{ asset('storage/' . $mainContent->image) }}" alt="{{ $mainContent->title }}" class="img-fluid">
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                            <p class="text-muted">No image available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.main-contents.edit', $mainContent->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.main-contents.destroy', $mainContent->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
