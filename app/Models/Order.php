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
            'pending'          => '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>',
            'confirmed'        => '<span class="badge" style="background:#0B3A63;color:#FFFFFF;"><i class="bi bi-check-circle-fill me-1"></i>Confirmed</span>',
            'processing'       => '<span class="badge bg-primary"><i class="bi bi-arrow-repeat me-1"></i>Processing</span>',
            'shipped'          => '<span class="badge bg-secondary"><i class="bi bi-truck me-1"></i>Shipped</span>',
            'out_for_delivery' => '<span class="badge bg-info text-dark"><i class="bi bi-bicycle me-1"></i>Out for Delivery</span>',
            'delivered'        => '<span class="badge bg-success"><i class="bi bi-bag-check-fill me-1"></i>Delivered</span>',
            'cancelled'        => '<span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Cancelled</span>',
            'returned'         => '<span class="badge bg-dark"><i class="bi bi-arrow-counterclockwise me-1"></i>Returned</span>',
            'refunded'         => '<span class="badge bg-secondary"><i class="bi bi-arrow-return-left me-1"></i>Refunded</span>',
            default            => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => '<span class="badge bg-success"><i class="bi bi-check2 me-1"></i>Paid</span>',
            'pending'  => '<span class="badge bg-warning text-dark"><i class="bi bi-clock-history me-1"></i>Pending</span>',
            'failed'   => '<span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>Failed</span>',
            'refunded' => '<span class="badge bg-secondary"><i class="bi bi-arrow-return-left me-1"></i>Refunded</span>',
            default    => '<span class="badge bg-light text-dark border">' . ucfirst($this->payment_status ?? 'Pending') . '</span>',
        };
    }

    public function getPaymentMethodNameAttribute(): string
    {
        $method = strtolower($this->payment_method ?? '');
        return match($method) {
            'cod'      => 'Cash on Delivery (COD)',
            'razorpay' => 'Online (Razorpay)',
            default    => strtoupper($method ?: 'N/A'),
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
