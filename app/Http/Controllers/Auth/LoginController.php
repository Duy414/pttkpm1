<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
    
         return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thực hiện đăng nhập
        if (Auth::attempt($credentials, $request->remember)) {
            
            // --- SỬA Ở ĐÂY: Kiểm tra trạng thái ngay sau khi xác thực thành công ---
            if (!Auth::user()->is_active) {
                // Nếu bị khóa thì đăng xuất ngay lập tức
                Auth::logout();
                
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.']);
            }
            // -----------------------------------------------------------------------

            // Nếu tài khoản active thì mới cho vào
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Đăng nhập thất bại (Sai email hoặc pass)
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}