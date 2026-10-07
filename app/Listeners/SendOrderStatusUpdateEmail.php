<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Mail\OrderStatusMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusUpdateEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order->load(['items.product', 'user']);
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusMail($order, $event->previousStatus));
        }
    }

    public function failed(OrderStatusUpdated $event, \Throwable $exception): void
    {
        \Log::error('OrderStatusUpdate mail failed: ' . $exception->getMessage(), [
            'order_id' => $event->order->id,
        ]);
    }
}
