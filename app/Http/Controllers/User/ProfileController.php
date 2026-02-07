<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Bắt buộc đăng nhập
        $this->middleware('auth');
    }

    /**
     * Kiểm tra tài khoản còn hoạt động hay không
     * Nếu bị khóa → logout + 403
     */
    private function ensureActiveUser()
    {
        $user = Auth::user();

        if (!$user || !$user->is_active) {
            Auth::logout();
            abort(403, 'Tài khoản của bạn đã bị khóa');
        }
    }

    /**
     * Hiển thị trang hồ sơ cá nhân
     */
    public function edit()
    {
        $this->ensureActiveUser();

        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function update(Request $request)
    {
        $this->ensureActiveUser();

        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Cập nhật hồ sơ thành công!');
    }

    /**
     * Đổi mật khẩu
     */
    public function updatePassword(Request $request)
    {
        $this->ensureActiveUser();

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.confirmed'    => 'Mật khẩu xác nhận không trùng khớp.',
            'new_password.min'          => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không chính xác.'
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('password_success', 'Đổi mật khẩu thành công!');
    }
}