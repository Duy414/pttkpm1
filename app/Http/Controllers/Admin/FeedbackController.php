<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Hiển thị danh sách phản hồi
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user')->latest();
        
        // Tìm kiếm theo tên người dùng
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        
        $feedbacks = $query->paginate(15);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Hiển thị chi tiết một phản hồi
     */
    public function show(Feedback $feedback)
    {
        return view('admin.feedbacks.show', compact('feedback'));
    }

    /**
     * Xóa một phản hồi
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
            ->with('success', 'Phản hồi đã được xóa thành công!');
    }
}
?>