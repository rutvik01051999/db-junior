@extends('admin.layouts.app')

@section('title', 'View Guest Of Honour')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Guest Of Honour Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('admin.guest-of-honours.edit', $guestOfHonour->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.guest-of-honours.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Season Name</th>
                                    <td>{{ $guestOfHonour->season_name }}</td>
                                </tr>
                                <tr>
                                    <th>Guest Name</th>
                                    <td>{{ $guestOfHonour->guest_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $guestOfHonour->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $guestOfHonour->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $guestOfHonour->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $guestOfHonour->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
