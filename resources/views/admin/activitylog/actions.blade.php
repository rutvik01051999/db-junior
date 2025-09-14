<div class="d-flex align-items-center">
    <!-- View Button -->
    <button type="button" class="btn btn-sm btn-outline-primary me-1" 
            data-bs-toggle="modal" 
            data-bs-target="#viewActivityModal{{ $q->id }}"
            title="View Details">
        <i class="bx bx-show"></i>
    </button>
</div>

<!-- View Activity Modal -->
<div class="modal fade" id="viewActivityModal{{ $q->id }}" tabindex="-1" aria-labelledby="viewActivityModalLabel{{ $q->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <style>
                @media (max-width: 768px) {
                    .modal-xl {
                        max-width: 95%;
                        margin: 1rem auto;
                    }
                }
                .text-break {
                    word-break: break-word;
                    overflow-wrap: break-word;
                }
                .table-responsive {
                    overflow-x: auto;
                }
                pre {
                    max-height: 300px;
                    overflow-y: auto;
                }
            </style>
            <div class="modal-header">
                <h5 class="modal-title" id="viewActivityModalLabel{{ $q->id }}">
                    <i class="bx bx-history me-2"></i>Activity Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $properties = json_decode($q->properties ?? '', true) ?? [];
                    $type = $properties['type'] ?? 'admin_activity';
                @endphp
                
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <h6 class="fw-semibold text-primary mb-3">Basic Information</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-semibold text-nowrap">Activity ID:</td>
                                    <td class="text-break">{{ $q->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap">Description:</td>
                                    <td class="text-break">{{ $q->description }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap">Type:</td>
                                    <td>
                                        @if($type === 'page_load')
                                            <span class="badge bg-info">Page Load</span>
                                        @elseif($type === 'form_submission')
                                            <span class="badge bg-success">Form Submission</span>
                                        @elseif($type === 'admin_activity')
                                            <span class="badge bg-primary">Admin Activity</span>
                                        @elseif($type === 'certificate_download')
                                            <span class="badge bg-warning">Certificate Download</span>
                                        @elseif($type === 'otp_activity')
                                            <span class="badge bg-secondary">OTP Activity</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap">Date & Time:</td>
                                    <td class="text-break">{{ $q->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 mb-4">
                        <h6 class="fw-semibold text-primary mb-3">User Information</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                @if($q->causer)
                                    <tr>
                                        <td class="fw-semibold text-nowrap">User:</td>
                                        <td class="text-break">{{ $q->causer->full_name ?? $q->causer->name ?? 'Admin User' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-nowrap">Email:</td>
                                        <td class="text-break">{{ $q->causer->email ?? 'N/A' }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="fw-semibold text-nowrap">User:</td>
                                        <td class="text-break">
                                            @if(isset($properties['ip']))
                                                Frontend User ({{ $properties['ip'] }})
                                            @else
                                                System
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                
                                @if(isset($properties['ip']))
                                    <tr>
                                        <td class="fw-semibold text-nowrap">IP Address:</td>
                                        <td class="text-break">{{ $properties['ip'] }}</td>
                                    </tr>
                                @endif
                                
                                @if(isset($properties['user_agent']))
                                    <tr>
                                        <td class="fw-semibold text-nowrap">User Agent:</td>
                                        <td class="text-break">
                                            <small class="text-muted" title="{{ $properties['user_agent'] }}">
                                                {{ Str::limit($properties['user_agent'], 60) }}
                                            </small>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="fw-semibold text-primary mb-3">Activity Details</h6>
                        <div class="card">
                            <div class="card-body">
                                @if($type === 'page_load')
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Page Name:</td>
                                                <td class="text-break">{{ $properties['page_name'] ?? 'Unknown' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">URL:</td>
                                                <td class="text-break">
                                                    <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary text-break" style="word-break: break-all;">
                                                        {{ $properties['url'] ?? 'Unknown' }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Method:</td>
                                                <td><span class="badge bg-secondary">{{ $properties['method'] ?? 'Unknown' }}</span></td>
                                            </tr>
                                            @if(isset($properties['referer']))
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">Referer:</td>
                                                    <td class="text-break">{{ $properties['referer'] }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    
                                @elseif($type === 'form_submission')
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Form Name:</td>
                                                <td class="text-break">{{ $properties['form_name'] ?? 'Unknown' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">URL:</td>
                                                <td class="text-break">
                                                    <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary text-break" style="word-break: break-all;">
                                                        {{ $properties['url'] ?? 'Unknown' }}
                                                    </a>
                                                </td>
                                            </tr>
                                            @if(isset($properties['form_data']) && is_array($properties['form_data']))
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">Form Data:</td>
                                                    <td>
                                                        <div class="mt-2">
                                                            @foreach($properties['form_data'] as $key => $value)
                                                                @if(!in_array($key, ['password', 'password_confirmation', 'token']))
                                                                    <span class="badge bg-light text-dark me-1 mb-1 text-break" style="word-break: break-word;">
                                                                        {{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    
                                @elseif($type === 'certificate_download')
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Student Name:</td>
                                                <td class="text-break">{{ $properties['student_name'] ?? 'Unknown' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Mobile Number:</td>
                                                <td class="text-break">{{ $properties['student_mobile'] ?? 'Unknown' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">URL:</td>
                                                <td class="text-break">
                                                    <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary text-break" style="word-break: break-all;">
                                                        {{ $properties['url'] ?? 'Unknown' }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                @elseif($type === 'otp_activity')
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Mobile Number:</td>
                                                <td class="text-break">{{ $properties['mobile_number'] ?? 'Unknown' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">Action:</td>
                                                <td class="text-break">{{ $q->description }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-nowrap">URL:</td>
                                                <td class="text-break">
                                                    <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary text-break" style="word-break: break-all;">
                                                        {{ $properties['url'] ?? 'Unknown' }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                @else
                                    <!-- Admin Activity or Other -->
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            @if(isset($properties['url']))
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">URL:</td>
                                                    <td class="text-break">
                                                        <a href="{{ $properties['url'] }}" target="_blank" class="text-primary text-break" style="word-break: break-all;">
                                                            {{ $properties['url'] }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(isset($properties['method']))
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">Method:</td>
                                                    <td><span class="badge bg-secondary">{{ $properties['method'] }}</span></td>
                                                </tr>
                                            @endif
                                            @if(isset($properties['admin_user_name']))
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">Admin User:</td>
                                                    <td class="text-break">{{ $properties['admin_user_name'] }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(!empty($properties))
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-3">Raw Properties</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word;"><code>{{ json_encode($properties, JSON_PRETTY_PRINT) }}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
