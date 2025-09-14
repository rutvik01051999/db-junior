<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'large.uploads' => \App\Http\Middleware\HandleLargeUploads::class,
            'certificate.rate.limit' => \App\Http\Middleware\CertificateRateLimit::class,
            'track.page.loads' => \App\Http\Middleware\TrackPageLoads::class,
            'track.admin.activities' => \App\Http\Middleware\TrackAdminActivities::class,
        ]);
        
        // Add global middleware
        $middleware->web(append: [
            \App\Http\Middleware\TrackPageLoads::class,
        ]);
        
        $middleware->group('admin', [
            \App\Http\Middleware\TrackAdminActivities::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
