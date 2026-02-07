<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể gán giá trị hàng loạt (mass assignable).
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    /**
     * Ép kiểu dữ liệu cho các thuộc tính.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',  // Đảm bảo định dạng số thập phân
        'stock' => 'integer'     // Ép kiểu số nguyên
    ];
    
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessor cho số lượng reviews
    public function getReviewsCountAttribute()
    {
        return $this->reviews->count();
    }

    // Accessor cho điểm trung bình
    public function getAverageRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function visibleReviews()
    {
        return $this->hasMany(Review::class)
            ->where('is_hidden', false);
    }

}
?>