@extends('layouts.admin')
@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Order #{{ $order->order_number }}</h5>
        <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-file-pdf me-1"></i>Invoice PDF
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        {{-- Order Items --}}
        <div class="table-card mb-4">
            <div class="table-card-header"><span>Order Items</span></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Product</th><th>Variant</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $item->image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
                                    <div style="font-size:.87rem;font-weight:600;">{{ $item->product_name }}</div>
                                </div>
                            </td>
                            <td style="font-size:.82rem;color:#6c757d;">{{ $item->variant_label ?? '—' }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="font-weight:700;">₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding: 16px 20px; border-top: 1px solid #e9ecef;">
                <div class="d-flex justify-content-end">
                    <table style="min-width:220px;font-size:.88rem;">
                        <tr><td class="text-muted pe-4">Subtotal</td><td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td></tr>
                        @if($order->discount_amount > 0)
                        <tr><td class="text-muted pe-4">Discount</td><td class="text-end text-success">-₹{{ number_format($order->discount_amount, 2) }}</td></tr>
                        @endif
                        {{-- <tr><td class="text-muted pe-4">Shipping</td><td class="text-end">₹{{ number_format($order->shipping_charge, 2) }}</td></tr> --}}
                        <tr style="border-top:2px solid #e9ecef;"><td class="fw-700 pt-2">Total</td><td class="text-end fw-700 pt-2" style="color:#2E6F40;font-size:1rem;">₹{{ number_format($order->total, 2) }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="form-card">
            <h6 class="fw-700 mb-3">Update Order Status</h6>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="row g-2">
                @csrf @method('PATCH')
                <div class="col-md-5">
                    <select name="status" class="form-select">
                        @foreach(['pending','confirmed','processing','shipped','out_for_delivery','delivered','cancelled','returned','refunded'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="tracking_number" class="form-control" placeholder="Tracking number (optional)" value="{{ $order->tracking_number }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-admin-primary text-white w-100">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-4">
        {{-- Customer Info --}}
        <div class="form-card mb-3">
            <h6 class="fw-700 mb-3 pb-2 border-bottom">Customer</h6>
            <div style="font-weight:600;">{{ $order->user->name }}</div>
            <div style="font-size:.84rem;color:#6c757d;">{{ $order->user->email }}</div>
            <div style="font-size:.84rem;color:#6c757d;">{{ $order->user->phone }}</div>
            <a href="{{ route('admin.customers.show', $order->user) }}" class="btn btn-sm btn-outline-secondary mt-2" style="font-size:.8rem;border-radius:6px;">View Profile</a>
        </div>

        {{-- Shipping Address --}}
        <div class="form-card mb-3">
            <h6 class="fw-700 mb-3 pb-2 border-bottom">Shipping Address</h6>
            <div style="font-size:.87rem;line-height:1.8;">
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_address_line1 }}<br>
                @if($order->shipping_address_line2) {{ $order->shipping_address_line2 }}<br> @endif
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}<br>
                {{ $order->shipping_country }}<br>
                📞 {{ $order->shipping_phone }}
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="form-card">
            <h6 class="fw-700 mb-3 pb-2 border-bottom">Payment Info</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted" style="font-size:.84rem;">Method</span>
                <span class="badge bg-light text-dark">{{ strtoupper($order->payment_method) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted" style="font-size:.84rem;">Status</span>
                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->payment_status) }}</span>
            </div>
            @if($order->payment)
            <div style="font-size:.78rem;color:#6c757d;word-break:break-all;">
                ID: {{ $order->payment->payment_id ?? 'N/A' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
