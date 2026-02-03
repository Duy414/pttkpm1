<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders for the authenticated user.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display the specified order for the authenticated user.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');
        return view('user.orders.show', compact('order'));
    }
    public function cancel(Order $order)
    {
        // 1. Kiểm tra chính chủ (để không hủy nhầm đơn người khác)
        if ($order->user_id != Auth::id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        // 2. Chỉ cho phép hủy khi trạng thái là 'pending'
        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();

            return back()->with('success', 'Đã hủy tour thành công.');
        }

        return back()->with('error', 'Không thể hủy tour này (Do đã hoàn thành hoặc đang xử lý).');
    }
}
?>