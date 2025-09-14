<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackAdminActivities
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only track admin routes
        if ($request->is('admin/*') && Auth::check()) {
            try {
                $action = $this->getActionFromRequest($request);
                if ($action) {
                    ActivityLogService::logAdminActivity($action, null, [
                        'url' => $request->fullUrl(),
                        'method' => $request->method(),
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to log admin activity: ' . $e->getMessage());
            }
        }
        
        return $response;
    }

    /**
     * Get action description from request
     */
    private function getActionFromRequest(Request $request): ?string
    {
        $route = $request->route();
        $action = $route->getActionMethod();
        $controller = class_basename($route->getController());
        
        // Map common actions
        $actionMap = [
            'index' => 'Viewed',
            'create' => 'Accessed create form',
            'store' => 'Created',
            'show' => 'Viewed details',
            'edit' => 'Accessed edit form',
            'update' => 'Updated',
            'destroy' => 'Deleted',
            'uploadCsv' => 'Uploaded CSV',
        ];
        
        $actionName = $actionMap[$action] ?? ucfirst($action);
        
        // Get module name from controller
        $moduleName = str_replace('Controller', '', $controller);
        $moduleName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $moduleName));
        
        return "{$actionName} {$moduleName}";
    }
}
