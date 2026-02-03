<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (có phân trang)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $price_range = $request->input('price_range');
        $stock = $request->input('stock');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($price_range, function ($query, $price_range) {
                switch ($price_range) {
                    case '1':
                        $query->where('price', '<', 5000000);
                        break;
                    case '2':
                        $query->whereBetween('price', [5000000, 10000000]);
                        break;
                    case '3':
                        $query->where('price', '>', 10000000);
                        break;
                }
            })
            ->when($stock, function ($query, $stock) {
                if ($stock === 'in') $query->where('stock', '>', 0);
                elseif ($stock === 'out') $query->where('stock', 0);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->all());

        // Lấy danh mục cho dropdown
        $categories = Category::all(); // <-- đây là phần bị thiếu trước đó

        return view('products.index', compact('products', 'categories')); // <-- truyền sang view
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:products',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }


    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show(Product $product)
    {
        $product->load(['reviews.user']);

        return view('products.show', compact('product'));
    }
    public function create()
    {
        return view('admin.products.create');
    }

    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|max:255|unique:products,name,' . $product['id'],
        'description' => 'required|min:10',
        'price' => 'required|numeric|min:0.01',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Xử lý ảnh mới (nếu có)
    if ($request->hasFile('image')) {
        // Xoá ảnh cũ nếu tồn tại
        if ($product->image && file_exists(public_path('storage/' . $product->image))) {
            unlink(public_path('storage/' . $product->image));
        }

        // Lưu ảnh mới
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // Cập nhật sản phẩm
    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}

}
?>