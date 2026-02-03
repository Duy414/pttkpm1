<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        $currentQuantity = $cart[$productId]['quantity'] ?? 0;

        if ($currentQuantity + 1 > $product->stock) {
            return redirect()->route('cart.index')
                ->with('error', "Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm trong kho.");
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $quantity = max(1, (int)$request->input('quantity'));
            if ($quantity > $product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm trong kho.");
            }

            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
?>
