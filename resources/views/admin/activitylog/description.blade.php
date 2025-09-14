@php
    $properties = json_decode($q->properties ?? '', true) ?? [];
    $type = $properties['type'] ?? 'admin_activity';
    $description = $q->description;
    
    // For front-end activities, show different format
    if ($type === 'page_load') {
        $pageName = $properties['page_name'] ?? 'Unknown Page';
        echo "<p class='mb-0'><span class='text-info'><i class='bx bx-globe'></i> Page Loaded:</span> <strong>{$pageName}</strong></p>";
    } elseif ($type === 'form_submission') {
        $formName = $properties['form_name'] ?? 'Unknown Form';
        echo "<p class='mb-0'><span class='text-success'><i class='bx bx-send'></i> Form Submitted:</span> <strong>{$formName}</strong></p>";
    } elseif ($type === 'certificate_download') {
        $studentName = $properties['student_name'] ?? 'Unknown Student';
        echo "<p class='mb-0'><span class='text-warning'><i class='bx bx-download'></i> Certificate Downloaded:</span> <strong>{$studentName}</strong></p>";
    } elseif ($type === 'otp_activity') {
        $mobile = $properties['mobile_number'] ?? 'Unknown';
        echo "<p class='mb-0'><span class='text-secondary'><i class='bx bx-message'></i> OTP Activity:</span> <strong>{$description}</strong> for <strong>{$mobile}</strong></p>";
    } else {
        // Admin activities - use original format
        $causer = $q->causer->full_name ?? $q->causer->name ?? 'System';
        $action = $description;
        
        $color = '';
        switch (strtolower($action)) {
            case 'created':
            case 'viewed create form':
                $color = 'success';
                break;
            case 'updated':
            case 'viewed edit form':
                $color = 'warning';
                break;
            case 'deleted':
                $color = 'danger';
                break;
            case 'viewed':
            case 'viewed details':
                $color = 'info';
                break;
            default:
                $color = 'primary';
                break;
        }
        
        echo "<p class='mb-0'><span class='text-{$color}'><i class='bx bx-user'></i> {$action}</span></p>";
    }
@endphp
