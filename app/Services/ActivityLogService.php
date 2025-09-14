<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLogService
{
    /**
     * Log front-end page load activity
     */
    public static function logPageLoad(Request $request, string $pageName = null)
    {
        $pageName = $pageName ?: $request->route()->getName() ?: $request->path();
        
        activity()
            ->withProperties([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'page_name' => $pageName,
                'type' => 'page_load'
            ])
            ->log("Page loaded: {$pageName}");
    }

    /**
     * Log front-end form submission
     */
    public static function logFormSubmission(Request $request, string $formName, array $formData = [])
    {
        // Remove sensitive data
        $sanitizedData = self::sanitizeFormData($formData);
        
        activity()
            ->withProperties([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'form_name' => $formName,
                'form_data' => $sanitizedData,
                'type' => 'form_submission'
            ])
            ->log("Form submitted: {$formName}");
    }

    /**
     * Log admin activity
     */
    public static function logAdminActivity(string $action, $subject = null, array $properties = [])
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        $log = activity()
            ->causedBy($user)
            ->withProperties(array_merge($properties, [
                'type' => 'admin_activity',
                'admin_user_id' => $user->id,
                'admin_user_name' => $user->full_name ?? $user->name ?? 'Unknown'
            ]));

        if ($subject) {
            $log->performedOn($subject);
        }

        $log->log($action);
    }

    /**
     * Log certificate download activity
     */
    public static function logCertificateDownload(Request $request, $studentData = null)
    {
        activity()
            ->withProperties([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'student_name' => $studentData['name'] ?? 'Unknown',
                'student_mobile' => $studentData['mobile_number'] ?? 'Unknown',
                'type' => 'certificate_download'
            ])
            ->log("Certificate downloaded");
    }

    /**
     * Log OTP activities
     */
    public static function logOtpActivity(Request $request, string $action, string $mobileNumber = null)
    {
        activity()
            ->withProperties([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'mobile_number' => $mobileNumber,
                'type' => 'otp_activity'
            ])
            ->log("OTP {$action}");
    }

    /**
     * Sanitize form data to remove sensitive information
     */
    private static function sanitizeFormData(array $data): array
    {
        $sensitiveFields = ['password', 'password_confirmation', 'token', 'api_key', 'secret'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[HIDDEN]';
            }
        }
        
        return $data;
    }

    /**
     * Get activity statistics
     */
    public static function getActivityStats()
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();
        
        return [
            'total_activities' => Activity::count(),
            'today_activities' => Activity::whereDate('created_at', $today)->count(),
            'this_month_activities' => Activity::where('created_at', '>=', $thisMonth)->count(),
            'page_loads' => Activity::whereJsonContains('properties->type', 'page_load')->count(),
            'form_submissions' => Activity::whereJsonContains('properties->type', 'form_submission')->count(),
            'admin_activities' => Activity::whereJsonContains('properties->type', 'admin_activity')->count(),
            'certificate_downloads' => Activity::whereJsonContains('properties->type', 'certificate_download')->count(),
            'otp_activities' => Activity::whereJsonContains('properties->type', 'otp_activity')->count(),
        ];
    }
}
