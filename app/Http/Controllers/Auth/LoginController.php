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
        // Kiểm tra nếu đã đăng nhập thì chuyển hướng
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
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Đăng nhập thất bại
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

        // Xóa session hiện tại
        $request->session()->invalidate();
        
        // Tạo lại CSRF token
        $request->session()->regenerateToken();

        // Chuyển hướng về trang chủ thay vì trả về view
        return redirect('/');
    }
}
?>