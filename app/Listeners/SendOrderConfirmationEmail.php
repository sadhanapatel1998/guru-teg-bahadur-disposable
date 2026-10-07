<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderPlaced $event): void
    {
        $order = $event->order->load(['items.product', 'user']);
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
        }
    }

    public function failed(OrderPlaced $event, \Throwable $exception): void
    {
        \Log::error('OrderConfirmation mail failed: ' . $exception->getMessage(), [
            'order_id' => $event->order->id,
        ]);
    }
}
