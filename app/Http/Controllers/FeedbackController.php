<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Hiển thị form gửi phản hồi
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Lưu phản hồi mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|min:10|max:1000'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return redirect()->route('feedback.create')
            ->with('success', 'Phản hồi của bạn đã được gửi thành công!');
    }

    /**
     * Hiển thị danh sách phản hồi (Admin)
     */
    public function index()
    {
        // Lấy tất cả phản hồi kèm user
        $feedbacks = Feedback::with('user')->latest()->paginate(15);
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Hiển thị chi tiết một phản hồi
     */
    public function show($id)
    {
        $feedback = Feedback::with('user')->findOrFail($id);
        return view('admin.feedbacks.show', compact('feedback'));
    }

    /**
     * Xóa một phản hồi
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
            ->with('success', 'Phản hồi đã được xóa thành công!');
    }
}
?>
