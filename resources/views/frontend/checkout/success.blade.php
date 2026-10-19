@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')

    <section class="py-5" style="background:#f5f7fb;">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                        {{-- Top Area --}}
                        <div class="text-center"
                            style="background:var(--kkt-gradient);padding:45px 20px;">

                                                <div
                                                    style="
                            width:70px;
                            height:70px;
                            background:#fff;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin:auto;
                            box-shadow:0 5px 15px rgba(0,0,0,.08);
                        ">
                                <i class="bi bi-check-circle-fill"
                                    style="
                                        font-size:38px;
                                        color:#198754;
                                    "></i>
                            </div>

                            <h4 class="fw-bold mt-3 mb-2">
                                Order Confirmed
                            </h4>

                            <p class="mb-0"
                                style="
                                font-size:.9rem;
                            ">
                                Your order has been placed successfully.
                            </p>

                        </div>

                        {{-- Body --}}
                        <div class="card-body p-4">

                            {{-- Order Number --}}
                            <div class="text-center mb-4">

                                <div class="text-muted" style="font-size:.8rem;">
                                    ORDER NUMBER
                                </div>

                                <div class="fw-bold"
                                    style="
                                    font-size:1.4rem;
                                    color:#000;
                                ">
                                    #{{ $order->order_number }}
                                </div>

                            </div>

                            {{-- Items & Bill Summary --}}
                            <div class="border rounded-4 p-3 mb-4" style="background:#fff;">
                                <h6 class="fw-bold mb-3" style="color:#000;">
                                    Order Items
                                </h6>
                                @foreach ($order->items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <div class="fw-semibold" style="font-size:.9rem; color:#0F172A;">
                                                {{ $item->product_name }}
                                            </div>
                                            @if($item->variant_label)
                                                <small class="text-muted d-block" style="font-size:.78rem;">
                                                    {{ $item->variant_label }}
                                                </small>
                                            @endif
                                            <small class="text-muted" style="font-size:.82rem;">
                                                Qty : {{ $item->quantity }}
                                            </small>
                                        </div>

                                        <div class="fw-bold" style="color:#000; font-size:.95rem;">
                                            ₹{{ number_format($item->total, 2) }}
                                        </div>
                                    </div>
                                @endforeach

                                <hr class="my-3" style="border-color:#E2E8F0;">

                                {{-- Subtotal --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted" style="font-size:.88rem;">
                                        Subtotal
                                    </span>
                                    <span class="fw-semibold" style="color:#000; font-size:.92rem;">
                                        ₹{{ number_format($order->subtotal, 2) }}
                                    </span>
                                </div>

                                {{-- Discount (if applicable) --}}
                                @if($order->discount_amount > 0)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted" style="font-size:.88rem;">
                                        Discount @if($order->coupon_code)<small class="text-success fw-bold">({{ $order->coupon_code }})</small>@endif
                                    </span>
                                    <span class="text-success fw-semibold" style="font-size:.92rem;">
                                        -₹{{ number_format($order->discount_amount, 2) }}
                                    </span>
                                </div>
                                @endif

                                {{-- Shipping Charge --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted" style="font-size:.88rem;">
                                        Shipping Charge
                                    </span>
                                    @if($order->shipping_charge > 0)
                                        <span class="fw-semibold" style="color:#000; font-size:.92rem;">
                                            ₹{{ number_format($order->shipping_charge, 2) }}
                                        </span>
                                    @else
                                        <span class="text-success fw-bold" style="font-size:.92rem;">
                                            <i class="bi bi-truck me-1"></i>Free
                                        </span>
                                    @endif
                                </div>

                                {{-- Tax / GST (if applicable) --}}
                                @if($order->tax_amount > 0)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted" style="font-size:.88rem;">
                                        Tax / GST
                                    </span>
                                    <span class="fw-semibold" style="color:#000; font-size:.92rem;">
                                        ₹{{ number_format($order->tax_amount, 2) }}
                                    </span>
                                </div>
                                @endif

                                <hr class="my-3" style="border-color:#E2E8F0;">

                                {{-- Total Paid --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold" style="font-size:1.05rem; color:#0F172A;">
                                        {{ $order->payment_status === 'paid' ? 'Total Paid' : ($order->payment_method === 'cod' ? 'Total Payable (COD)' : 'Total Paid') }}
                                    </span>

                                    <span class="fw-bold"
                                        style="
                                        color:#198754;
                                        font-size:1.25rem;
                                    ">
                                        ₹{{ number_format($order->total, 2) }}
                                    </span>
                                </div>

                            </div>

                            {{-- Buttons --}}
                            <div class="text-center d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('shop') }}"
                                    class="btn px-4 py-2 rounded fw-bold"
                                    style="
                                        background:var(--kkt-gradient);
                                        color:#fff;
                                        border:none;
                                        box-shadow:var(--kkt-shadow);
                                        transition:.3s;
                                    ">
                                    <i class="bi bi-bag me-1"></i>
                                    Continue Shopping
                                </a>
                                @auth
                                <a href="{{ route('account.orders.show', $order) }}"
                                    class="btn btn-outline-secondary px-4 py-2 rounded fw-bold">
                                    <i class="bi bi-receipt me-1"></i>
                                    View Order
                                </a>
                                @endauth
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
