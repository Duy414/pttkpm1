<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách Tour (quản trị)
     */
    public function index()
    {
        // Sắp xếp tour mới nhất lên đầu
        $products = Product::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo Tour mới
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Lưu Tour mới vào database
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|max:255|unique:products', // Tên tour không trùng
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0', // Số chỗ trống
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Ảnh tour
        ], [
            // Tùy chỉnh thông báo lỗi tiếng Việt (nếu cần)
            'name.required' => 'Vui lòng nhập tên Tour.',
            'name.unique' => 'Tên Tour này đã tồn tại.',
            'price.required' => 'Vui lòng nhập giá vé.',
            'image.image' => 'File tải lên phải là hình ảnh.',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            // Lưu vào storage/app/public/products
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Tour du lịch mới đã được khởi tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa Tour
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Cập nhật thông tin Tour
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($product['id'])
            ],
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý cập nhật ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại để tiết kiệm dung lượng
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Lưu ảnh mới
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thông tin Tour đã được cập nhật thành công!');
    }

    /**
     * Xóa Tour khỏi hệ thống
     */
    public function destroy(Product $product)
    {
        // Xóa ảnh đính kèm nếu có
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Tour đã được xóa khỏi hệ thống!');
    }

    /**
     * Xem chi tiết Tour (Front-end)
     */
    public function show(Product $product)
    {
        // Load quan hệ reviews và user của review để hiển thị đánh giá
        $product->load('reviews.user');
        
        return view('products.show', compact('product'));
    }
}