<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'shipping',
        'total',
        'email',
        'first_name',
        'last_name',
        'country',
        'address',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // -----------------
    // Relationships
    // -----------------

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }

    protected static function generateOrderNumber(): string
    {
        // Example: ORD-20260126-9F3A2C
        return 'P2P-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
