<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // ✅ Thêm dòng này để có thể truy cập Product model
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Hiển thị form thanh toán
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    // Xử lý thanh toán
    public function process(Request $request)
    {
        // ✅ Bước 1: Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang trống!');
        }

        // ✅ Bước 2: Validate dữ liệu người mua
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
        ]);

        // ✅ Bước 3: Tính tổng tiền
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // ✅ Bước 4: Tạo đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'customer_email' => $validated['email'],
            'customer_address' => $validated['address'],
        ]);

        // ✅ Bước 5: Lưu từng sản phẩm trong đơn và cập nhật tồn kho
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // ✅ Giảm số lượng tồn kho
            $product = Product::find($productId);
            if ($product) {
                $product->stock -= $item['quantity'];
                if ($product->stock < 0) {
                    $product->stock = 0; // Tránh bị âm
                }
                $product->save();
            }
        }

        // ✅ Bước 6: Xóa giỏ hàng sau khi thanh toán
        session()->forget('cart');

        // ✅ Bước 7: Chuyển hướng và thông báo thành công
        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }
}
