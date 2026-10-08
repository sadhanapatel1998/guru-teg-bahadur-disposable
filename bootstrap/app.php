<?php

// Automatically remove stale route and config caches to prevent subfolder routing conflicts in local development
$cacheDir = __DIR__.'/cache';
if (file_exists($r = $cacheDir.'/routes-v7.php')) {
    @unlink($r);
}
if (file_exists($c = $cacheDir.'/config.php')) {
    @unlink($c);
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AdminAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->instance('routes.cached', false);

return $app;

