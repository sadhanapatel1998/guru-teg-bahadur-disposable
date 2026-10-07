<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'product_id', 'product_variant_id', 'quantity'];

    public function user(): BelongsTo           { return $this->belongsTo(User::class); }
    public function product(): BelongsTo        { return $this->belongsTo(Product::class); }
    public function productVariant(): BelongsTo { return $this->belongsTo(ProductVariant::class); }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->productVariant) {
            return (float) ($this->productVariant->effective_price ?? 0.0);
        }
        return (float) ($this->product?->effective_price ?? 0.0);
    }

    public function getLineTotalAttribute(): float
    {
        return $this->effective_price * $this->quantity;
    }
}
