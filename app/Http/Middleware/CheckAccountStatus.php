<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra đã đăng nhập chưa
        if (Auth::check()) {
            // Lấy thông tin user MỚI NHẤT từ database (bỏ qua cache cũ)
            $user = Auth::user()->fresh(); 

            // Nếu user không tồn tại hoặc is_active = 0
            if (!$user || $user->is_active == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->withErrors(['email' => 'Tài khoản đã bị khóa phiên làm việc.']);
            }
        }

        return $next($request);
    }
}