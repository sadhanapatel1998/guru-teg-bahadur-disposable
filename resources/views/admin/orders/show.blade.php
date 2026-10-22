@extends('layouts.admin')
@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
            <h5 class="fw-700 mb-0">Order #{{ $order->order_number }}</h5>
            {!! $order->status_badge !!}
            {!! $order->payment_status_badge !!}
            <span class="badge bg-light text-dark border"><i class="bi bi-wallet2 text-primary me-1"></i>{{ $order->payment_method_name }}</span>
        </div>
        <small class="text-muted"><i class="bi bi-clock me-1"></i>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</small>
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

{{-- Order Dashboard KPI Summary Strip --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="border-left: 4px solid #0B3A63 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-uppercase fw-600" style="font-size:0.75rem; letter-spacing:0.5px;">Order Status</div>
                    <div class="mt-2">{!! $order->status_badge !!}</div>
                </div>
                <div class="stat-icon" style="background:#EEF5FA;color:#0B3A63;">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="border-left: 4px solid #1E88E5 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-uppercase fw-600" style="font-size:0.75rem; letter-spacing:0.5px;">Payment Method</div>
                    <div class="mt-2 fw-700 text-dark" style="font-size:0.92rem;">
                        <i class="bi bi-wallet2 text-primary me-1"></i>{{ $order->payment_method_name }}
                    </div>
                </div>
                <div class="stat-icon" style="background:#E3F2FD;color:#1E88E5;">
                    <i class="bi bi-credit-card"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="border-left: 4px solid {{ $order->payment_status === 'paid' ? '#16A34A' : '#F59E0B' }} !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-uppercase fw-600" style="font-size:0.75rem; letter-spacing:0.5px;">Payment Status</div>
                    <div class="mt-2">{!! $order->payment_status_badge !!}</div>
                </div>
                <div class="stat-icon" style="background:{{ $order->payment_status === 'paid' ? '#DEF7EC' : '#FEF3C7' }};color:{{ $order->payment_status === 'paid' ? '#03543F' : '#92400E' }};">
                    <i class="bi {{ $order->payment_status === 'paid' ? 'bi-check2-circle' : 'bi-clock-history' }}"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="border-left: 4px solid #D9232E !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label text-uppercase fw-600" style="font-size:0.75rem; letter-spacing:0.5px;">Total Payable</div>
                    <div class="mt-2 fw-700" style="color:#D9232E;font-size:1.15rem;">₹{{ number_format($order->total, 2) }}</div>
                </div>
                <div class="stat-icon" style="background:#FDE8E8;color:#D9232E;">
                    <i class="bi bi-currency-rupee"></i>
                </div>
            </div>
        </div>
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
            <h6 class="fw-700 mb-3">Update Order & Payment Status</h6>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="row g-2">
                @csrf @method('PATCH')
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1 fw-600">Order Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','confirmed','processing','shipped','out_for_delivery','delivered','cancelled','returned','refunded'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small mb-1 fw-600">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        @foreach(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'] as $psKey => $psLabel)
                        <option value="{{ $psKey }}" {{ $order->payment_status === $psKey ? 'selected' : '' }}>{{ $psLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small mb-1 fw-600">Tracking Number</label>
                    <input type="text" name="tracking_number" class="form-control" placeholder="Tracking (optional)" value="{{ $order->tracking_number }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
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

        {{-- Order & Payment Overview --}}
        <div class="form-card">
            <h6 class="fw-700 mb-3 pb-2 border-bottom d-flex justify-content-between align-items-center">
                <span>Order & Payment Info</span>
                <span class="badge bg-light text-secondary border fw-normal" style="font-size:0.75rem;">#{{ $order->order_number }}</span>
            </h6>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span class="text-muted fw-600" style="font-size:.84rem;">Order Status</span>
                {!! $order->status_badge !!}
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span class="text-muted fw-600" style="font-size:.84rem;">Payment Method</span>
                <span class="badge bg-light text-dark border px-2 py-1" style="font-weight:600;"><i class="bi bi-wallet2 text-primary me-1"></i>{{ $order->payment_method_name }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span class="text-muted fw-600" style="font-size:.84rem;">Payment Status</span>
                {!! $order->payment_status_badge !!}
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-600" style="font-size:.84rem;">Total Payable</span>
                <span class="fw-700 text-dark" style="font-size:1rem;">₹{{ number_format($order->total, 2) }}</span>
            </div>
            @if($order->payment)
            <div class="pt-2 border-top mt-2" style="font-size:.78rem;color:#6c757d;word-break:break-all;">
                <strong>Transaction ID:</strong> {{ $order->payment->payment_id ?? 'N/A' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
