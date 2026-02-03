<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])
            ->latest()
            ->paginate(20);
            
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function approve(Review $review)
    {
        $review->update(['approved' => true]);
        return back()->with('success', 'Đánh giá đã được duyệt!');
    }
    
    public function reject(Review $review)
    {
        $review->update(['approwed' => true]);
        return back()->with('success', 'Đánh giá đã bị từ chối!');
    }
    
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đánh giá đã bị xóa!');
    }
}

?>