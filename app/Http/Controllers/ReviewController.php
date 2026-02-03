<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'required|string|max:1000',
        ]);

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        // Tạo đánh giá
        Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'approved' => true, // Tự động duyệt
        ]);

        return back()->with('success', 'Cảm ơn đánh giá của bạn!');
    }

    public function update(Request $request, Review $review)
    {
        // Kiểm tra quyền sở hữu
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'title', 'comment']));

        return back()->with('success', 'Đánh giá đã được cập nhật!');
    }

    public function destroy(Review $review)
    {
        // Kiểm tra quyền sở hữu
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Đánh giá đã được xóa!');
    }
}
?>