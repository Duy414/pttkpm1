<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // Chỉ admin mới vào được
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Danh sách người dùng
     */
    public function index()
    {
        // Hiện tất cả user, mới nhất lên trên
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tạo user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu user mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_admin'  => $request->is_admin ?? false,
            'is_active' => true, // QUAN TRỌNG
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Người dùng đã được tạo thành công!');
    }

    /**
     * Form chỉnh sửa user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->is_admin ?? false,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    /**
     * KHÓA tài khoản (thay cho delete)
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản của mình!');
        }

        // KHÓA (soft delete)
        $user->delete();

        return back()->with('success', 'Tài khoản đã bị khóa!');
    }

    public function lock($id)
    {
        // Tìm user theo ID
        $user = User::findOrFail($id);

        // Cập nhật trạng thái active = 0 (false)
        $user->is_active = false; // Hoặc 0 tùy vào database của bạn
        $user->save();

        return redirect()->back()->with('success', 'Đã khóa tài khoản thành công!');
    }

    public function unlock($id)
    {
        // Tìm user theo ID
        $user = User::findOrFail($id);

        // Cập nhật trạng thái active = 1 (true)
        $user->is_active = true; // Hoặc 1
        $user->save();

        return redirect()->back()->with('success', 'Đã mở khóa tài khoản!');
    }
    /**
     * Cấp quyền admin
     */
    public function makeAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự cấp quyền admin cho chính mình!');
        }

        $user->update(['is_admin' => true]);

        return back()->with('success', 'Đã cấp quyền admin cho ' . $user->name);
    }

    /**
     * Thu hồi quyền admin
     */
    public function revokeAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự thu hồi quyền admin của chính mình!');
        }

        $user->update(['is_admin' => false]);

        return back()->with('success', 'Đã thu hồi quyền admin của ' . $user->name);
    }
}