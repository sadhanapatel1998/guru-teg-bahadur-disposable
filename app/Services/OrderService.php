<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                'status'                => (strtolower($checkoutData['payment_method'] ?? '') === 'cod') ? 'confirmed' : 'pending',
                'payment_method'        => $checkoutData['payment_method'],
                'payment_status'        => 'pending',
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

            // Save delivery address to user's dashboard saved addresses
            if ($userId) {
                $this->saveShippingAddressToUser((int)$userId, $checkoutData);
            }

            // event(new OrderPlaced($order));

            return $order;
        });
    }

    /**
     * Automatically save the order's delivery location to user's saved addresses
     */
    private function saveShippingAddressToUser(int $userId, array $checkoutData): void
    {
        try {
            $line1   = trim($checkoutData['shipping_address_line1'] ?? '');
            $line2   = !empty($checkoutData['shipping_address_line2']) ? trim($checkoutData['shipping_address_line2']) : null;
            $city    = trim($checkoutData['shipping_city'] ?? '');
            $state   = trim($checkoutData['shipping_state'] ?? '');
            $pincode = trim($checkoutData['shipping_pincode'] ?? '');
            $name    = trim($checkoutData['shipping_name'] ?? '');
            $phone   = trim($checkoutData['shipping_phone'] ?? '');

            if (empty($line1) || empty($city) || empty($pincode)) {
                return;
            }

            // Check if this exact location already exists for this user
            $existing = Address::where('user_id', $userId)
                ->whereRaw('LOWER(TRIM(address_line1)) = ?', [strtolower($line1)])
                ->whereRaw('LOWER(TRIM(city)) = ?', [strtolower($city)])
                ->whereRaw('LOWER(TRIM(pincode)) = ?', [strtolower($pincode)])
                ->first();

            if (!$existing) {
                $hasAddresses = Address::where('user_id', $userId)->exists();

                Address::create([
                    'user_id'       => $userId,
                    'name'          => $name,
                    'phone'         => $phone,
                    'address_line1' => $line1,
                    'address_line2' => $line2,
                    'city'          => $city,
                    'state'         => $state,
                    'pincode'       => $pincode,
                    'country'       => $checkoutData['shipping_country'] ?? 'India',
                    'type'          => 'home',
                    'is_default'    => !$hasAddresses,
                ]);
            } else {
                // Update recipient name or phone if existing record was missing them
                $updates = [];
                if (!empty($name) && empty($existing->name)) {
                    $updates['name'] = $name;
                }
                if (!empty($phone) && empty($existing->phone)) {
                    $updates['phone'] = $phone;
                }
                if (!empty($updates)) {
                    $existing->update($updates);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to save order address to dashboard: ' . $e->getMessage());
        }
    }

    public function updateStatus(Order $order, string $status, ?string $trackingNumber = null, ?string $paymentStatus = null): Order
    {
        $previousStatus = $order->status;

        $updates = [
            'status'          => $status,
            'tracking_number' => $trackingNumber ?? $order->tracking_number,
            'delivered_at'    => $status === 'delivered' ? ($order->delivered_at ?? now()) : $order->delivered_at,
        ];

        if ($paymentStatus) {
            $updates['payment_status'] = $paymentStatus;
        }

        $order->update($updates);

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
