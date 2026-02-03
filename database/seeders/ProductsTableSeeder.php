<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Sản phẩm 1',
            'description' => 'Mô tả sản phẩm 1',
            'price' => 199000,
            'stock' => 100,
            'image' => 'https://via.placeholder.com/300'
        ]);

        // Thêm nhiều sản phẩm khác...
    }
}