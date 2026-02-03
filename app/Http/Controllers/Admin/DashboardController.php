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
            $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $pendingOrderCount = Order::where('status', 'pending')->count();

        // Lọc ngày
        $date = $request->input('date'); // format: 'YYYY-MM-DD'

        $totalRevenueQuery = Order::where('status', 'completed');

        if ($date) {
            $totalRevenueQuery->whereDate('created_at', $date);
        }

        $totalRevenue = $totalRevenueQuery->sum('total');

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
            'date'
        ));
        }
    }
?>