<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackPageLoads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only track GET requests for front-end pages (not admin or API)
        if ($request->isMethod('GET') && 
            !$request->is('admin/*') && 
            !$request->is('api/*') &&
            !$request->is('_debugbar/*')) {
            
            // Track page load asynchronously to avoid slowing down the response
            try {
                ActivityLogService::logPageLoad($request);
            } catch (\Exception $e) {
                // Log error but don't break the request
                Log::error('Failed to log page load: ' . $e->getMessage());
            }
        }
        
        return $response;
    }
}
