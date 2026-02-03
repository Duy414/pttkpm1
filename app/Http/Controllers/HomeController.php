<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        // Lấy danh sách sản phẩm nổi bật (ví dụ: 8 sản phẩm mới nhất)
        $featuredProducts = Product::latest()->take(8)->get();
        
        // Lấy feedback mới nhất (có thể kèm thông tin người dùng)
        $recentFeedbacks = Feedback::with('user')->latest()->take(6)->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'recentFeedbacks' => $recentFeedbacks
        ]);
    }
}
?>