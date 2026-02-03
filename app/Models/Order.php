<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
    ];

    public $timestamps = true;

    // ✅ Hiển thị trạng thái thân thiện
    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ][$this->status] ?? $this->status;
    }

    // ✅ Màu trạng thái
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    // ✅ Một order có nhiều item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }


    // ✅ Một order thuộc về 1 user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
