<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ===== Thống kê cơ bản =====
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $pendingOrderCount = Order::where('status', 'pending')->count();

        // ===== Nhận ngày từ form =====
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // ===== Query doanh thu (chỉ đơn hoàn thành) =====
        $totalRevenueQuery = Order::where('status', 'completed');

        // ===== LỌC THEO KHOẢNG NGÀY =====
        if ($startDate && $endDate) {
            $totalRevenueQuery->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // ===== Tổng doanh thu =====
        $totalRevenue = $totalRevenueQuery->sum('total');

        // ===== Booking mới nhất =====
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'userCount',
            'productCount',
            'orderCount',
            'pendingOrderCount',
            'totalRevenue',
            'recentOrders',
            'startDate',
            'endDate'
        ));
    }
}