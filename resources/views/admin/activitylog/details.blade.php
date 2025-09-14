@php
    $type = $properties['type'] ?? 'admin_activity';
@endphp

<div class="activity-details">
    @if($type === 'page_load')
        <div class="mb-2">
            <strong>Page:</strong> {{ $properties['page_name'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>URL:</strong> 
            <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary">
                {{ Str::limit($properties['url'] ?? 'Unknown', 50) }}
            </a>
        </div>
        <div class="mb-2">
            <strong>IP:</strong> {{ $properties['ip'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>User Agent:</strong> 
            <small class="text-muted">{{ Str::limit($properties['user_agent'] ?? 'Unknown', 30) }}</small>
        </div>
    @elseif($type === 'form_submission')
        <div class="mb-2">
            <strong>Form:</strong> {{ $properties['form_name'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>IP:</strong> {{ $properties['ip'] ?? 'Unknown' }}
        </div>
        @if(isset($properties['form_data']) && is_array($properties['form_data']))
            <div class="mb-2">
                <strong>Data:</strong>
                <ul class="list-unstyled mb-0">
                    @foreach($properties['form_data'] as $key => $value)
                        @if(!in_array($key, ['password', 'password_confirmation', 'token']))
                            <li><small>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</small></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    @elseif($type === 'admin_activity')
        <div class="mb-2">
            <strong>URL:</strong> 
            <a href="{{ $properties['url'] ?? '#' }}" target="_blank" class="text-primary">
                {{ Str::limit($properties['url'] ?? 'Unknown', 50) }}
            </a>
        </div>
        <div class="mb-2">
            <strong>Method:</strong> <span class="badge bg-secondary">{{ $properties['method'] ?? 'Unknown' }}</span>
        </div>
        <div class="mb-2">
            <strong>IP:</strong> {{ $properties['ip'] ?? 'Unknown' }}
        </div>
    @elseif($type === 'certificate_download')
        <div class="mb-2">
            <strong>Student:</strong> {{ $properties['student_name'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>Mobile:</strong> {{ $properties['student_mobile'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>IP:</strong> {{ $properties['ip'] ?? 'Unknown' }}
        </div>
    @elseif($type === 'otp_activity')
        <div class="mb-2">
            <strong>Mobile:</strong> {{ $properties['mobile_number'] ?? 'Unknown' }}
        </div>
        <div class="mb-2">
            <strong>IP:</strong> {{ $properties['ip'] ?? 'Unknown' }}
        </div>
    @else
        <div class="mb-2">
            <strong>Details:</strong>
            <pre class="mb-0"><small>{{ json_encode($properties, JSON_PRETTY_PRINT) }}</small></pre>
        </div>
    @endif
</div>
