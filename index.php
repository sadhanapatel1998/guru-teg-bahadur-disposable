<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Clean up stale route & config caches
if (file_exists($r = __DIR__.'/bootstrap/cache/routes-v7.php')) {
    @unlink($r);
}
if (file_exists($c = __DIR__.'/bootstrap/cache/config.php')) {
    @unlink($c);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$request = Request::capture();

// Normalize subfolder request on XAMPP/Apache when accessed without trailing slash
$uri = $request->server->get('REQUEST_URI', '');
$scriptName = $request->server->get('SCRIPT_NAME', '');
$baseDir = rtrim(dirname($scriptName), '/\\');
if ($baseDir !== '' && ($uri === $baseDir || $uri === $baseDir.'/')) {
    $request->server->set('REQUEST_URI', $baseDir.'/');
}

$app->handleRequest($request);

