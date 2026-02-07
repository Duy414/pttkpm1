<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckAccountStatus; // 1. Import

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // ❌ SAI: Dùng append() nó chạy trước Session -> Auth::user() bị null
        // $middleware->append(CheckAccountStatus::class); 

        // ✅ ĐÚNG: Đưa vào nhóm WEB (Chạy sau khi đã có Session)
        $middleware->web(append: [
            CheckAccountStatus::class,
        ]);

        // Alias
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();