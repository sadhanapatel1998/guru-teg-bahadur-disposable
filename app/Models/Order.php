<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number', 'user_id', 'coupon_id',
        'shipping_name', 'shipping_phone', 'shipping_address_line1',
        'shipping_address_line2', 'shipping_city', 'shipping_state',
        'shipping_pincode', 'shipping_country',
        'subtotal', 'shipping_charge', 'tax_amount', 'discount_amount', 'total',
        'coupon_code', 'status', 'payment_method', 'payment_status',
        'notes', 'tracking_number', 'shipping_partner', 'delivered_at',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total'           => 'decimal:2',
        'delivered_at'    => 'datetime',
    ];

    public function user(): BelongsTo      { return $this->belongsTo(User::class); }
    public function coupon(): BelongsTo    { return $this->belongsTo(Coupon::class); }
    public function items(): HasMany       { return $this->hasMany(OrderItem::class); }
    public function payment(): HasOne      { return $this->hasOne(Payment::class); }
    public function returnRequest(): HasOne { return $this->hasOne(ReturnRequest::class); }

    public static function generateOrderNumber(): string
    {
        return 'FBD-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Ymd');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'          => '<span class="badge bg-warning">Pending</span>',
            'confirmed'        => '<span class="badge bg-info">Confirmed</span>',
            'processing'       => '<span class="badge bg-primary">Processing</span>',
            'shipped'          => '<span class="badge bg-secondary">Shipped</span>',
            'out_for_delivery' => '<span class="badge bg-info">Out for Delivery</span>',
            'delivered'        => '<span class="badge bg-success">Delivered</span>',
            'cancelled'        => '<span class="badge bg-danger">Cancelled</span>',
            'returned'         => '<span class="badge bg-dark">Returned</span>',
            'refunded'         => '<span class="badge bg-secondary">Refunded</span>',
            default            => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeReturned(): bool
    {
        return $this->status === 'delivered' && $this->delivered_at
            && $this->delivered_at->diffInDays(now()) <= 7;
    }
}
