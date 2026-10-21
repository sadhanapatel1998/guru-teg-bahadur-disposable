@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav><ol class="breadcrumb mb-0" style="font-size:.84rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ol></nav>
    </div>
</div>

<section class="py-4 py-lg-5" style="background:#F8FAFC;min-height:75vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 flex-wrap gap-2">
            <h4 class="fw-700 text-dark mb-0" style="font-family:'Poppins',sans-serif;">Shopping Cart (<span id="cart-item-count-badge">{{ $items->count() }}</span>)</h4>
            <a href="{{ route('shop') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1.5" style="border-radius:10px;font-weight:600;">
                <i class="bi bi-arrow-left"></i>
                <span>Continue Shopping</span>
            </a>
        </div>

        @if($items->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
            <i class="bi bi-bag-x" style="font-size:4rem;color:#CBD5E1;display:block;"></i>
            <h4 class="mt-3 fw-700" style="color:var(--kkt-dark);">Your cart is empty</h4>
            <p class="text-muted">Looks like you haven't added anything yet.</p>
            <a href="{{ route('shop') }}" class="btn text-white px-4 mt-2" style="background:#D9232E;border-radius:12px;font-weight:600;"><i class="bi bi-cart3 me-1"></i> Start Shopping</a>
        </div>
        @else
        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Desktop Cart Table (Visible >= 768px) --}}
                <div class="d-none d-md-block">
                    <div class="table-responsive bg-white rounded-4 border overflow-hidden shadow-sm">
                        <table class="table mb-0 align-middle">
                            <thead style="background:#F8FAFC;" class="cart-table-head">
                                <tr>
                                    <th style="padding:16px;font-size:.8rem;text-transform:uppercase;color:#475569;font-weight:700;">Product</th>
                                    <th style="padding:16px;font-size:.8rem;text-transform:uppercase;color:#475569;font-weight:700;">Price</th>
                                    <th style="padding:16px;font-size:.8rem;text-transform:uppercase;color:#475569;font-weight:700;">Qty</th>
                                    <th style="padding:16px;font-size:.8rem;text-transform:uppercase;color:#475569;font-weight:700;">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr id="cart-row-{{ $item->id }}">
                                    <td style="padding:16px;">
                                        @if($item->product)
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" style="width:60px;height:60px;min-width:60px;object-fit:cover;border-radius:10px;border:1px solid #e9ecef;">
                                            <div>
                                                <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none" style="font-weight:600;font-size:.9rem;color:#0B3A63;">{{ $item->product->name }}</a>
                                                @if($item->productVariant)
                                                <div style="font-size:.78rem;color:#6c757d;">{{ $item->productVariant->label }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">Product no longer available</span>
                                        @endif
                                    </td>
                                    <td style="padding:16px;font-weight:700;color:#0B3A63;">₹{{ number_format($item->effective_price, 2) }}</td>
                                    <td style="padding:16px;">
                                        <div class="d-flex align-items-center border rounded" style="width:fit-content;border-radius:8px!important;overflow:hidden;background:#f8f9fa;">
                                            <button onclick="updateCart({{ $item->id }}, {{ max(1, $item->quantity - 1) }})" class="btn btn-light btn-sm" style="border:none;padding:5px 12px;font-weight:700;">−</button>
                                            <span id="qty-{{ $item->id }}" style="padding:5px 12px;font-weight:700;color:#1e293b;">{{ $item->quantity }}</span>
                                            <button onclick="updateCart({{ $item->id }}, {{ $item->quantity + 1 }})" class="btn btn-light btn-sm" style="border:none;padding:5px 12px;font-weight:700;">+</button>
                                        </div>
                                    </td>
                                    <td style="padding:16px;font-weight:700;color:#0B3A63;" id="total-{{ $item->id }}">₹{{ number_format($item->line_total, 2) }}</td>
                                    <td style="padding:16px;text-align:right;">
                                        <button onclick="removeCart({{ $item->id }})" class="btn btn-light btn-sm" style="border-radius:8px;color:#dc3545;" title="Remove"><i class="bi bi-trash3"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Cart Cards (< 768px: NO HORIZONTAL SCROLL) --}}
                <div class="d-md-none d-flex flex-column gap-3">
                    @foreach($items as $item)
                    <div class="bg-white rounded-4 border p-3 shadow-sm position-relative" id="cart-card-{{ $item->id }}">
                        <div class="d-flex gap-3 align-items-start">
                            {{-- Product Image --}}
                            @if($item->product)
                                <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" style="width:70px;height:70px;min-width:70px;object-fit:cover;border-radius:12px;border:1px solid #e9ecef;">
                            @else
                                <div style="width:70px;height:70px;min-width:70px;background:#f8f9fa;border-radius:12px;border:1px solid #e9ecef;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif

                            {{-- Product Info --}}
                            <div class="flex-grow-1 min-w-0 pe-4">
                                @if($item->product)
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none text-dark fw-600 d-block" style="font-size:0.92rem;line-height:1.3;margin-bottom:2px;">
                                        {{ $item->product->name }}
                                    </a>
                                    @if($item->productVariant)
                                        <div class="text-muted small mb-1" style="font-size:0.78rem;">{{ $item->productVariant->label }}</div>
                                    @endif
                                    <div class="fw-700 mt-1" style="color:#0B3A63;font-size:0.95rem;">
                                        ₹{{ number_format($item->effective_price, 2) }}
                                    </div>
                                @else
                                    <span class="text-muted small">Product no longer available</span>
                                @endif
                            </div>

                            {{-- Remove Button --}}
                            <button onclick="removeCart({{ $item->id }})" class="btn btn-sm text-danger position-absolute top-0 end-0 m-2 p-1 border-0" style="background:transparent;font-size:1.05rem;" title="Remove item" aria-label="Remove item">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>

                        {{-- Divider --}}
                        <hr class="my-2.5 opacity-25">

                        {{-- Stepper & Subtotal --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-1">
                            <div class="d-flex align-items-center border rounded-3" style="width:fit-content;background:#f8f9fa;overflow:hidden;">
                                <button onclick="updateCart({{ $item->id }}, {{ max(1, $item->quantity - 1) }})" class="btn btn-light btn-sm px-2.5 py-1 border-0 fw-bold" style="font-size:0.95rem;background:#f1f5f9;">−</button>
                                <span class="px-3 fw-bold text-dark" style="font-size:0.88rem;">{{ $item->quantity }}</span>
                                <button onclick="updateCart({{ $item->id }}, {{ $item->quantity + 1 }})" class="btn btn-light btn-sm px-2.5 py-1 border-0 fw-bold" style="font-size:0.95rem;background:#f1f5f9;">+</button>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small" style="font-size:0.75rem;">Total: </span>
                                <span class="fw-bold" style="color:#0B3A63;font-size:1.02rem;">₹{{ number_format($item->line_total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Coupon --}}
                <div class="mt-3 p-3 p-md-4 bg-white rounded-4 border shadow-sm">
                    <div class="d-flex gap-2">
                        <input type="text" id="coupon-input" class="form-control" placeholder="Enter coupon code" value="{{ session('coupon_code') }}">
                        <button onclick="applyCoupon()" class="btn text-white px-4" style="background:#0B3A63;border-radius:10px;font-weight:600;white-space:nowrap;">Apply</button>
                        @if(session('coupon_code'))
                        <a href="{{ route('cart.coupon.remove') }}" class="btn btn-outline-danger px-3"><i class="bi bi-x-circle"></i></a>
                        @endif
                    </div>
                    <div id="coupon-message" class="mt-2" style="font-size:.84rem;"></div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="p-4 bg-white rounded-4 border shadow-sm" style="position:sticky;top:130px;">
                    <h6 class="fw-700 text-dark mb-4" style="font-family:'Poppins',sans-serif;">Order Summary</h6>
                    <div id="cart-summary">
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><span class="fw-600">₹{{ number_format($totals['subtotal'], 2) }}</span></div>
                        @if($totals['discount'] > 0)
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Discount</span><span class="text-success fw-600">-₹{{ number_format($totals['discount'], 2) }}</span></div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>

                            @if($totals['shippingCharge'] > 0)
                                <span class="fw-600">₹{{ number_format($totals['shippingCharge'], 2) }}</span>
                            @else
                                <span class="text-success fw-bold">
                                    <i class="bi bi-truck me-1"></i>Free
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1.15rem;">
                            <span>Total</span>
                            <span style="color:#0B3A63;">₹{{ number_format($totals['total'], 2) }}</span>
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('checkout.index') }}" class="btn text-white w-100 py-2.5" style="background:linear-gradient(135deg, #0B3A63 0%, #062A49 100%);border-radius:12px;font-weight:700;box-shadow:0 4px 14px rgba(11,58,99,0.22);">
                        Proceed to Checkout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn text-white w-100 py-2.5" style="background:linear-gradient(135deg, #0B3A63 0%, #062A49 100%);border-radius:12px;font-weight:700;box-shadow:0 4px 14px rgba(11,58,99,0.22);">
                        Login to Checkout
                    </a>
                    @endauth
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:12px;font-weight:600;">Continue Shopping</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function updateCart(id, qty) {
    $.ajax({ url: '{{ url("cart") }}/' + id, method: 'PATCH', data: { quantity: qty } })
        .done(res => {
            if (res.success) {
                location.reload();
            }
        });
}

function removeCart(id) {
    $.ajax({ url: '{{ url("cart") }}/' + id, method: 'DELETE' })
        .done(res => {
            if (res.success) {
                document.getElementById('cart-row-' + id)?.remove();
                document.getElementById('cart-card-' + id)?.remove();
                if (typeof window.updateCartHeader === 'function') {
                    window.updateCartHeader(res.count, res.cart_total || res.subtotal_formatted);
                } else if (typeof window.updateCartCount === 'function') {
                    window.updateCartCount(res.count, res.cart_total || res.subtotal_formatted);
                }
                if (res.count === 0) location.reload();
            }
        });
}

function applyCoupon() {
    const code = document.getElementById('coupon-input').value.trim();
    $.post('{{ route("cart.coupon.apply") }}', { coupon_code: code })
        .done(res => {
            const el = document.getElementById('coupon-message');
            el.style.color = res.success ? 'green' : 'red';
            el.textContent = res.message;
            if (res.success) setTimeout(() => location.reload(), 1000);
        });
}
</script>
@endpush
