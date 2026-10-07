<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Razorpay\Api\Api;

class PaymentService
{
    private Api $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );
    }

    public function createRazorpayOrder(Order $order): array
    {
        $rpOrder = $this->razorpay->order->create([
            'amount'   => (int) ($order->total * 100), // paise
            'currency' => 'INR',
            'receipt'  => $order->order_number,
        ]);

        Payment::create([
            'order_id'           => $order->id,
            'user_id'            => $order->user_id,
            'razorpay_order_id'  => $rpOrder->id,
            'method'             => 'razorpay',
            'status'             => 'pending',
            'amount'             => $order->total,
        ]);

        return [
            'razorpay_order_id' => $rpOrder->id,
            'amount'            => $rpOrder->amount,
            'currency'          => $rpOrder->currency,
            'key_id'            => config('services.razorpay.key_id'),
        ];
    }

    public function verifyAndCapture(array $data): bool
    {
        try {
            $this->razorpay->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $data['razorpay_order_id'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature'  => $data['razorpay_signature'],
            ]);

            $payment = Payment::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
            $payment->update([
                'payment_id'          => $data['razorpay_payment_id'],
                'razorpay_signature'  => $data['razorpay_signature'],
                'status'              => 'paid',
                'paid_at'             => now(),
            ]);

            $payment->order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            event(new \App\Events\OrderPlaced($payment->order));

            return true;
        } catch (\Exception $e) {
            logger()->error('Razorpay verification failed: ' . $e->getMessage());
            return false;
        }
    }

    public function initiateRefund(Order $order): void
    {
        $payment = $order->payment;
        if (!$payment || $payment->status !== 'paid') return;

        $refund = $this->razorpay->payment->fetch($payment->payment_id)->refund([
            'amount' => (int) ($order->total * 100),
        ]);

        $payment->update([
            'refund_id'     => $refund->id,
            'refund_amount' => $order->total,
            'status'        => 'refunded',
        ]);

        $order->update(['payment_status' => 'refunded']);
    }
}
