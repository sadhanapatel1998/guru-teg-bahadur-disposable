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

<section class="py-5">
    <div class="container">
        @if($items->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x" style="font-size:4rem;color:#e9ecef;display:block;"></i>
            <h4 class="mt-3 fw-700" style="color:var(--kkt-dark);">Your cart is empty</h4>
            <p class="text-muted">Looks like you haven't added anything yet.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary px-4 mt-2">Start Shopping</a>
        </div>
        @else
        <div class="row g-4">
            <div class="col-lg-8">
               <div class="table-responsive" style="background:#fff;border-radius:14px;border:1px solid #e9ecef;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                     <table class="table mb-0" style="min-width:700px;">
                        <thead style="background:#f8f9fa;" class="cart-table-head">
                            <tr>
                                <th style="padding:16px;font-size:.8rem;text-transform:uppercase;">Product</th>
                                <th style="padding:16px;font-size:.8rem;text-transform:uppercase;">Price</th>
                                <th style="padding:16px;font-size:.8rem;text-transform:uppercase;">Qty</th>
                                <th style="padding:16px;font-size:.8rem;text-transform:uppercase;">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr id="cart-row-{{ $item->id }}">
                                <td style="padding:16px;">
                                    @if($item->product)
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item->product->thumbnail_url }}" style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                                        <div>
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none" style="font-weight:600;font-size:.9rem;color:var(--kkt-dark);">{{ $item->product->name }}</a>
                                            @if($item->productVariant)
                                            <div style="font-size:.78rem;color:#6c757d;">{{ $item->productVariant->label }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-muted">Product no longer available</span>
                                    @endif
                                </td>
                                <td style="padding:16px;font-weight:700;color:var(--kkt-primary);">₹{{ number_format($item->effective_price, 2) }}</td>
                                <td style="padding:16px;">
                                    <div class="d-flex align-items-center border rounded" style="width:fit-content;border-radius:8px!important;overflow:hidden;">
                                        <button onclick="updateCart({{ $item->id }}, {{ max(1, $item->quantity - 1) }})" class="btn btn-light btn-sm" style="border:none;padding:5px 10px;">−</button>
                                        <span id="qty-{{ $item->id }}" style="padding:5px 10px;font-weight:700;">{{ $item->quantity }}</span>
                                        <button onclick="updateCart({{ $item->id }}, {{ $item->quantity + 1 }})" class="btn btn-light btn-sm" style="border:none;padding:5px 10px;">+</button>
                                    </div>
                                </td>
                                <td style="padding:16px;font-weight:700;" id="total-{{ $item->id }}">₹{{ number_format($item->line_total, 2) }}</td>
                                <td style="padding:16px;">
                                    <button onclick="removeCart({{ $item->id }})" class="btn btn-light btn-sm" style="border-radius:8px;color:#dc3545;"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Coupon --}}
                <div class="mt-3 p-4" style="background:#fff;border-radius:14px;border:1px solid #e9ecef;">
                    <div class="d-flex gap-2">
                        <input type="text" id="coupon-input" class="form-control" placeholder="Enter coupon code" value="{{ session('coupon_code') }}">
                        <button onclick="applyCoupon()" class="tn btn-outline-pink px-4" style="white-space:nowrap;">Apply</button>
                        @if(session('coupon_code'))
                        <a href="{{ route('cart.coupon.remove') }}" class="btn btn-outline-danger px-3"><i class="bi bi-x-circle"></i></a>
                        @endif
                    </div>
                    <div id="coupon-message" class="mt-2" style="font-size:.84rem;"></div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="p-4" style="background:#fff;border-radius:14px;border:1px solid #e9ecef;position:sticky;top:80px;">
                    <h6 class="fw-700 mb-4">Order Summary</h6>
                    <div id="cart-summary">
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><span>₹{{ number_format($totals['subtotal'], 2) }}</span></div>
                        @if($totals['discount'] > 0)
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Discount</span><span class="text-success">-₹{{ number_format($totals['discount'], 2) }}</span></div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>

                            @if($totals['shippingCharge'] > 0)
                                <span>₹{{ number_format($totals['shippingCharge'], 2) }}</span>
                            @else
                                <span class="text-success fw-bold">
                                    <i class="bi bi-truck me-1"></i>Free
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1.1rem;">
                            <span>Total</span>
                            <span style="color:var(--kkt-primary);">₹{{ number_format($totals['total'], 2) }}</span>
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-2" style="border-radius:10px;font-weight:700;">
                        Proceed to Checkout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 py-2" style="border-radius:10px;font-weight:700;">
                        Login to Checkout
                    </a>
                    @endauth
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;">Continue Shopping</a>
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
                document.getElementById('qty-' + id).textContent = qty;
                location.reload();
            }
        });
}

function removeCart(id) {
    $.ajax({ url: '{{ url("cart") }}/' + id, method: 'DELETE' })
        .done(res => {
            if (res.success) {
                document.getElementById('cart-row-' + id)?.remove();
                if (typeof window.updateCartCount === 'function') {
                    window.updateCartCount(res.count);
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
