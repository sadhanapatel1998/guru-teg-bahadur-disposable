<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    private function getIdentifier(): array
    {
        return Auth::check()
            ? ['user_id' => Auth::id()]
            : ['session_id' => Session::getId()];
    }

    public function getItems()
    {
        // Automatically prune any cart items whose product was deleted
        Cart::where($this->getIdentifier())
            ->whereDoesntHave('product')
            ->delete();

        return Cart::with(['product.images', 'productVariant'])
            ->where($this->getIdentifier())
            ->whereHas('product')
            ->get();
    }

    public function count(): int
    {
        return Cart::where($this->getIdentifier())
            ->whereHas('product')
            ->sum('quantity');
    }

    public function add(int $productId, int $quantity = 1, ?int $variantId = null): void
    {
        $identifier = $this->getIdentifier();
        $query = Cart::where($identifier)
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId);

        $cartItem = $query->first();
        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create(array_merge($identifier, [
                'product_id'         => $productId,
                'product_variant_id' => $variantId,
                'quantity'           => $quantity,
            ]));
        }
    }

    public function update(int $cartId, int $quantity): void
    {
        Cart::where($this->getIdentifier())->where('id', $cartId)
            ->update(['quantity' => $quantity]);
    }

    public function remove(int $cartId): void
    {
        Cart::where($this->getIdentifier())->where('id', $cartId)->delete();
    }

    public function clear(): void
    {
        Cart::where($this->getIdentifier())->delete();
    }

    public function totals(?string $couponCode = null): array
    {
        $items    = $this->getItems();
        $subtotal = $items->sum(fn($i) => $i->line_total);
        $discount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', strtoupper($couponCode))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $shippingCharge = $this->calculateShipping($subtotal - $discount);
        $taxAmount      = $this->calculateTax($subtotal - $discount);
        $total          = ($subtotal - $discount) + $shippingCharge + $taxAmount;

        return compact('subtotal', 'discount', 'shippingCharge', 'taxAmount', 'total');
    }

    private function calculateShipping(float $subtotal): float
    {
        $freeThreshold = (float) setting('free_shipping_threshold', 500);
        $shippingRate  = (float) setting('shipping_charge', 50);
        return $subtotal >= $freeThreshold ? 0 : $shippingRate;
    }

    private function calculateTax(float $subtotal): float
    {
        // Tax already baked in product prices for India GST typically
        return 0;
    }

    /** Merge guest cart into user cart after login */
    public function mergeTo(int $userId): void
    {
        $sessionId = Session::getId();
        $guestItems = Cart::where('session_id', $sessionId)->get();

        foreach ($guestItems as $item) {
            $existing = Cart::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->where('product_variant_id', $item->product_variant_id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                $item->update(['user_id' => $userId, 'session_id' => null]);
            }
        }
    }
}
