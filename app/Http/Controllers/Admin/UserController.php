<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
   public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    /**
     * Hiển thị form tạo người dùng mới
     */
    public function create()
    {
        // Gate::authorize('admin-access');

        return view('admin.users.create');
    }

    /**
     * Lưu người dùng mới vào database
     */
    public function store(Request $request)
    {
        // Gate::authorize('admin-access');


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin ?? false,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa người dùng
     */
    public function edit(User $user)
    {
        // Gate::authorize('admin-access');

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update(Request $request, User $user)
    {
        // Gate::authorize('admin-access');


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean']
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin ?? false,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
    {
        // Gate::authorize('admin-access');


        // Ngăn chặn xóa chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được xóa thành công!');
    }

    public function profile()
    {
        return view('user.profile');
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function makeAdmin(User $user)
    {
        // Gate::authorize('admin-access');

        
        // Không thể tự cấp quyền admin cho chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể tự cấp quyền admin cho chính mình!');
        }
        
        $user->update(['is_admin' => true]);
        
        return redirect()->back()
            ->with('success', 'Đã cấp quyền admin cho người dùng: ' . $user->name);
    }

    public function revokeAdmin(User $user)
    {
        // Gate::authorize('admin-access');

        
        // Không thể tự thu hồi quyền admin của chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể tự thu hồi quyền admin của chính mình!');
        }
        
        $user->update(['is_admin' => false]);
        
        return redirect()->back()
            ->with('success', 'Đã thu hồi quyền admin của người dùng: ' . $user->name);
    }
        
}
?>