<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Nhớ import Auth

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Phải đăng nhập (Auth::check)
        // 2. Hàm isAdmin() phải trả về true
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Nếu không phải admin -> Đuổi về trang chủ
        return redirect('/')->with('error', 'Bạn không có quyền truy cập Admin!');
    }
}