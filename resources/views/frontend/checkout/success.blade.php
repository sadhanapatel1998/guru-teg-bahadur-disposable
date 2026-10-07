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

                            <h4 class="text-white fw-bold mt-3 mb-2">
                                Order Confirmed
                            </h4>

                            <p class="mb-0"
                                style="
                                color:rgba(255,255,255,.8);
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

                            {{-- Items --}}
                            <div class="border rounded-4 p-3 mb-4" style="background:#fff;">
                                <h6 class="fw-bold mb-3" style="color:#000;">
                                    Order Items
                                </h6>
                                @foreach ($order->items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>

                                            <div class="fw-semibold" style="font-size:.9rem;">
                                                {{ $item->product_name }}
                                            </div>

                                            <small class="text-muted">
                                                Qty : {{ $item->quantity }}
                                            </small>

                                        </div>

                                        <div class="fw-bold"
                                            style="
                                        color:#000;
                                        font-size:.95rem;
                                    ">
                                            ₹{{ number_format($item->total, 2) }}
                                        </div>

                                    </div>
                                @endforeach

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="fw-bold">
                                        Total Paid
                                    </span>

                                    <span class="fw-bold"
                                        style="
                                        color:#198754;
                                        font-size:1.2rem;
                                    ">
                                        ₹{{ number_format($order->total, 2) }}
                                    </span>

                                </div>

                            </div>

                            {{-- Button --}}
                            <div class="text-center">

                               <a href="{{ route('shop') }}"
                                    class="btn px-4 py-2 rounded fw-bold"
                                    style="
                                            background:var(--kkt-gradient);
                                            color:#fff;
                                            border:none;
                                            box-shadow:var(--kkt-shadow);
                                            transition:.3s;
                                    ">
                                        <i class="bi bi-bag me-2"></i>
                                        Continue Shopping
                                    </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
