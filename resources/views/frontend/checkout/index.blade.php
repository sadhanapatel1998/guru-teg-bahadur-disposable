@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav><ol class="breadcrumb mb-0" style="font-size:.84rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol></nav>
    </div>
</div>

<section class="py-4">
<div class="container">
<form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            {{-- Saved Addresses --}}
            @if($addresses->count())
            <div class="p-4 bg-white rounded-4 border mb-4">
                <h6 class="fw-700 mb-3">Saved Addresses</h6>
                @foreach($addresses as $addr)
                <div class="border rounded-3 p-3 mb-2" onclick="fillAddress({{ json_encode($addr) }}, this)"
                     style="cursor:pointer;transition:all .2s;" id="addr-{{ $addr->id }}">
                    <div class="d-flex justify-content-between">
                        <strong style="font-size:.88rem;">{{ $addr->name }}</strong>
                        <span class="badge" style="background:var(--kkt-light);color:var(--kkt-primary);font-size:.7rem;">{{ ucfirst($addr->type) }}</span>
                    </div>
                    <div style="font-size:.82rem;color:#555;margin-top:4px;">{{ $addr->full_address }}</div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Shipping Details --}}
            <div class="p-4 bg-white rounded-4 border mb-4">
                <h6 class="fw-700 mb-3">Shipping Information</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-size:.85rem;">Full Name *</label>
                        <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror" value="{{ old('shipping_name', Auth::user()->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-size:.85rem;">Phone *</label>
                        <input type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', Auth::user()->phone) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-size:.85rem;">Address Line 1 *</label>
                        <input type="text" name="shipping_address_line1" id="addr_line1" class="form-control" value="{{ old('shipping_address_line1') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-size:.85rem;">Address Line 2</label>
                        <input type="text" name="shipping_address_line2" id="addr_line2" class="form-control" value="{{ old('shipping_address_line2') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">City *</label>
                        <input type="text" name="shipping_city" id="addr_city" class="form-control" value="{{ old('shipping_city') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">State *</label>
                        <input type="text" name="shipping_state" id="addr_state" class="form-control" value="{{ old('shipping_state') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">Pincode *</label>
                        <input type="text" name="shipping_pincode" id="addr_pincode" class="form-control" value="{{ old('shipping_pincode') }}" required>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="p-4 bg-white rounded-4 border">
                <h6 class="fw-700 mb-3">Payment Method</h6>
                <div class="d-flex flex-column gap-3">
                    <label class="d-flex align-items-center gap-3 p-3 border rounded-3" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="razorpay" checked class="form-check-input mt-0">
                        <div>
                            <div class="fw-600" style="font-size:.9rem;">Online Payment</div>
                            <div style="font-size:.78rem;color:#6c757d;">Cards, UPI, Net Banking, Wallets via Razorpay</div>
                        </div>
                        <img src="https://razorpay.com/favicon.png" height="24" class="ms-auto">
                    </label>
                    <label class="d-flex align-items-center gap-3 p-3 border rounded-3" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="cod" class="form-check-input mt-0">
                        <div>
                            <div class="fw-600" style="font-size:.9rem;">Cash on Delivery</div>
                            <div style="font-size:.78rem;color:#6c757d;">Pay when you receive the order</div>
                        </div>
                     <div class="ms-auto fw-bold text-success fs-5">
                            ₹
                        </div>
                    </label>
                </div>
                <div class="mt-3">
                    <label class="form-label fw-600" style="font-size:.85rem;">Order Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions..."></textarea>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-5">
            <div class="p-4 bg-white rounded-4 border" style="position:sticky;top:80px;">
                <h6 class="fw-700 mb-3">Order Summary</h6>
                @foreach($items as $item)
                @if($item->product)
                <div class="d-flex gap-3 align-items-center mb-3">
                    <div class="position-relative">
                        <img src="{{ $item->product->thumbnail_url }}" style="width:52px;height:52px;object-fit:cover;border-radius:8px;">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background:var(--kkt-primary);font-size:.65rem;">{{ $item->quantity }}</span>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.85rem;font-weight:600;">{{ Str::limit($item->product->name, 30) }}</div>
                        @if($item->productVariant)<div style="font-size:.75rem;color:#6c757d;">{{ $item->productVariant->label }}</div>@endif
                    </div>
                    <div style="font-weight:700;font-size:.9rem;">₹{{ number_format($item->line_total, 2) }}</div>
                </div>
                @endif
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.87rem;">Subtotal</span><span>₹{{ number_format($totals['subtotal'], 2) }}</span></div>
                @if($totals['discount'] > 0)
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.87rem;">Discount</span><span class="text-success">-₹{{ number_format($totals['discount'], 2) }}</span></div>
                @endif
                {{-- <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.87rem;">Shipping</span><span>{{ $totals['shippingCharge'] > 0 ? '₹'.number_format($totals['shippingCharge'],2) : 'Free' }}</span></div> --}}
                <hr>
                <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1.1rem;">
                    <span>Total</span><span style="color:var(--kkt-primary);">₹{{ number_format($totals['total'], 2) }}</span>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-700" style="border-radius:10px;font-size:1rem;">
                    <i class="bi bi-lock me-2"></i>Place Order
                </button>
                <p class="text-center mt-3" style="font-size:.75rem;color:#6c757d;"><i class="bi bi-shield-check me-1"></i>Secured by 256-bit SSL encryption</p>
            </div>
        </div>
    </div>
</form>
</div>
</section>

@push('scripts')
<script>
function fillAddress(addr, el) {
    document.querySelectorAll('[id^="addr-"]').forEach(e => e.style.borderColor = '#e9ecef');
    el.style.borderColor = 'var(--kkt-primary)';
    document.getElementById('addr_line1').value  = addr.address_line1 || '';
    document.getElementById('addr_line2').value  = addr.address_line2 || '';
    document.getElementById('addr_city').value   = addr.city || '';
    document.getElementById('addr_state').value  = addr.state || '';
    document.getElementById('addr_pincode').value= addr.pincode || '';
}
</script>
@endpush
@endsection
