@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Video Details</h4>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Title</th>
                                <td>{{ $video->title }}</td>
                            </tr>
                            <tr>
                                <th>Video</th>
                                <td>
                                    <video width="400" controls>
                                        <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge {{ $video->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $video->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $video->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $video->updated_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this video?')">
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
</div>
@endsection
