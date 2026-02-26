<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'subtotal', 'tax', 'shipping', 'total',
        'first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state',
        'zip_code', 'country', 'notes', 'payment_method', 'payment_status',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
