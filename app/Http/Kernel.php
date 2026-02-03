<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
   protected $routeMiddleware = [
        // middleware mặc định có sẵn
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // THÊM DÒNG NÀY ↓↓↓
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
?>