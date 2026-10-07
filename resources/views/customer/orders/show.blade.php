@extends('layouts.app')
@section('title', 'Order #' . $order->order_number)
@section('content')
<div class="py-5" style="background:#f8f9fa;min-height:70vh;">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-700 mb-1">Order #{{ $order->order_number }}</h5>
            <small class="text-muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('account.orders.invoice', $order) }}" class="btn btn-outline-secondary btn-sm">Download Invoice</a>
            <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white rounded-4 border p-4 mb-4">
                <h6 class="fw-700 mb-3">Items</h6>
                @foreach($order->items as $item)
                <div class="d-flex gap-3 align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ $item->image_url }}" style="width:64px;height:64px;object-fit:cover;border-radius:10px;">
                    <div class="flex-grow-1">
                        <a href="{{ route('product.show', $item->product?->slug ?? '#') }}" class="text-decoration-none fw-600" style="font-size:.9rem;color:var(--kkt-dark);">{{ $item->product_name }}</a>
                        @if($item->variant_label)<div style="font-size:.78rem;color:#6c757d;">{{ $item->variant_label }}</div>@endif
                        <div style="font-size:.8rem;color:#6c757d;">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</div>
                    </div>
                    <div class="fw-700" style="color:var(--kkt-primary);">₹{{ number_format($item->total, 2) }}</div>
                </div>
                @endforeach
                <div class="d-flex flex-column align-items-end gap-1 mt-2" style="font-size:.88rem;">
                    <div class="d-flex justify-content-between" style="width:240px;"><span class="text-muted">Subtotal</span><span>₹{{ number_format($order->subtotal, 2) }}</span></div>
                    @if($order->discount_amount > 0)<div class="d-flex justify-content-between" style="width:240px;"><span class="text-muted">Discount</span><span class="text-success">-₹{{ number_format($order->discount_amount, 2) }}</span></div>@endif
                    <div class="d-flex justify-content-between" style="width:240px;"><span class="text-muted">Shipping</span><span>₹{{ number_format($order->shipping_charge, 2) }}</span></div>
                    <div class="d-flex justify-content-between fw-700 pt-2 border-top" style="width:240px;font-size:1rem;"><span>Total</span><span style="color:var(--kkt-primary);">₹{{ number_format($order->total, 2) }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white rounded-4 border p-4 mb-3">
                <h6 class="fw-700 mb-3">Shipping Address</h6>
                <div style="font-size:.87rem;line-height:1.8;color:#555;">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address_line1 }}<br>
                    @if($order->shipping_address_line2){{ $order->shipping_address_line2 }}<br>@endif
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}<br>
                    📞 {{ $order->shipping_phone }}
                </div>
            </div>
            <div class="bg-white rounded-4 border p-4">
                <h6 class="fw-700 mb-3">Order Status</h6>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.84rem;">Status</span>{!! $order->status_badge !!}</div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.84rem;">Payment</span><span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->payment_status) }}</span></div>
                @if($order->tracking_number)<div class="d-flex justify-content-between"><span class="text-muted" style="font-size:.84rem;">Tracking</span><span style="font-size:.84rem;font-weight:600;">{{ $order->tracking_number }}</span></div>@endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
