@extends('admin.layouts.app')

@section('title', 'View Participant')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Participant Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.participants.edit', $participant->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.participants.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Title</th>
                                    <td>{{ $participant->title }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Participants</th>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $participant->number_of_participants }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $participant->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $participant->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $participant->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $participant->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
