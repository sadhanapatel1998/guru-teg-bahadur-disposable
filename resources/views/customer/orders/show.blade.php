@extends('layouts.app')
@section('title', 'Order #' . $order->order_number)
@section('content')
<div class="py-4 py-lg-5" style="background:#F8FAFC;min-height:75vh;">
<div class="container">
    @include('customer.partials.topbar', [
        'title' => '#' . $order->order_number,
        'parentTitle' => 'Orders',
        'parentRoute' => route('account.orders'),
        'backRoute' => route('account.orders'),
        'backLabel' => 'Back to Orders'
    ])

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <h5 class="fw-700 text-dark mb-0" style="font-family:'Poppins',sans-serif;">Order #{{ $order->order_number }}</h5>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap mt-1" style="font-size:.84rem;color:#64748b;">
                <span><i class="bi bi-calendar3 me-1"></i>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('account.orders.invoice', $order) }}" class="btn btn-sm text-white" style="background:#0B3A63;border-radius:10px;font-weight:600;"><i class="bi bi-file-earmark-arrow-down me-1"></i> Download Invoice</a>
            <a href="{{ route('account.orders') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px;font-weight:600;"><i class="bi bi-arrow-left me-1"></i> Orders</a>
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
                <h6 class="fw-700 mb-3">Order & Payment Info</h6>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted" style="font-size:.84rem;">Order Status</span>
                    {!! $order->status_badge !!}
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted" style="font-size:.84rem;">Payment Method</span>
                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size:.78rem;font-weight:600;"><i class="bi bi-wallet2 me-1 text-primary"></i>{{ $order->payment_method_name }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted" style="font-size:.84rem;">Payment Status</span>
                    {!! $order->payment_status_badge !!}
                </div>
                @if($order->tracking_number)
                <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                    <span class="text-muted" style="font-size:.84rem;">Tracking</span>
                    <span style="font-size:.84rem;font-weight:600;">{{ $order->tracking_number }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
