<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private CartService $cartService) {}

    public function createFromCart(array $checkoutData): Order
    {
        return DB::transaction(function () use ($checkoutData) {
            $userId      = $checkoutData['user_id'];
            $cartItems   = $this->cartService->getItems();
            $couponCode  = $checkoutData['coupon_code'] ?? null;
            $totals      = $this->cartService->totals($couponCode);

            $coupon = null;
            if ($couponCode) {
                $coupon = Coupon::where('code', strtoupper($couponCode))->first();
            }

            // Create order
            $order = Order::create([
                'order_number'          => Order::generateOrderNumber(),
                'user_id'               => $userId,
                'coupon_id'             => $coupon?->id,
                'shipping_name'         => $checkoutData['shipping_name'],
                'shipping_phone'        => $checkoutData['shipping_phone'],
                'shipping_address_line1'=> $checkoutData['shipping_address_line1'],
                'shipping_address_line2'=> $checkoutData['shipping_address_line2'] ?? null,
                'shipping_city'         => $checkoutData['shipping_city'],
                'shipping_state'        => $checkoutData['shipping_state'],
                'shipping_pincode'      => $checkoutData['shipping_pincode'],
                'shipping_country'      => $checkoutData['shipping_country'] ?? 'India',
                'subtotal'              => $totals['subtotal'],
                'shipping_charge'       => $totals['shippingCharge'],
                'tax_amount'            => $totals['taxAmount'],
                'discount_amount'       => $totals['discount'],
                'total'                 => $totals['total'],
                'coupon_code'           => $couponCode,
                'payment_method'        => $checkoutData['payment_method'],
                'payment_status'        => $checkoutData['payment_method'] === 'cod' ? 'pending' : 'pending',
                'notes'                 => $checkoutData['notes'] ?? null,
            ]);

            // Create order items + deduct stock
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $variant = $cartItem->productVariant;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name'       => $product->name,
                    'product_sku'        => $variant?->sku ?? $product->sku,
                    'variant_label'      => $variant?->label,
                    'product_image'      => $product->thumbnail,
                    'quantity'           => $cartItem->quantity,
                    'price'              => $product->price,
                    'sale_price'         => $product->sale_price,
                    'tax_rate'           => $product->tax_rate,
                    'total'              => $cartItem->line_total,
                ]);

                // Deduct stock
                if ($variant && $variant->stock !== null) {
                    $variant->decrement('stock', $cartItem->quantity);
                } elseif ($product->manage_stock) {
                    $product->decrement('stock', $cartItem->quantity);
                }
            }

            // Increment coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Clear cart
            $this->cartService->clear();

            // event(new OrderPlaced($order));

            return $order;
        });
    }

   public function updateStatus(Order $order, string $status, ?string $trackingNumber = null): Order
{
    $previousStatus = $order->status;

    $order->update([
        'status'          => $status,
        'tracking_number' => $trackingNumber ?? $order->tracking_number,
        'delivered_at'    => $status === 'delivered' ? now() : $order->delivered_at,
    ]);

    event(new OrderStatusUpdated($order, $previousStatus));

    return $order->fresh();
}

    public function cancel(Order $order): void
    {
        if (!$order->canBeCancelled()) {
            throw new \Exception('Order cannot be cancelled at this stage.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            // Restore stock
            foreach ($order->items as $item) {
                if ($item->productVariant) {
                    $item->productVariant->increment('stock', $item->quantity);
                } else {
                    $item->product?->increment('stock', $item->quantity);
                }
            }

            // Refund if paid via Razorpay
            if ($order->payment_status === 'paid' && $order->payment_method === 'razorpay') {
                app(PaymentService::class)->initiateRefund($order);
            }
        });
    }
}
