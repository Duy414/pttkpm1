<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Quan hệ 1-n: 1 danh mục có nhiều sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
