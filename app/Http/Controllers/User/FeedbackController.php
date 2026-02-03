<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function show(Feedback $feedback)
    {
        return view('admin.feedbacks.show', compact('feedback'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|min:10|max:1000'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return redirect()->route('user.feedback.create')
            ->with('success', 'Phản hồi của bạn đã được gửi thành công!');
    }
}
?>