@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="py-4 py-lg-5" style="background:#F8FAFC;min-height:75vh;">
<div class="container">
    @include('customer.partials.topbar', ['title' => 'My Orders'])

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-700 text-dark mb-0" style="font-family:'Poppins',sans-serif;">My Orders</h4>
        @if(isset($orders) && method_exists($orders, 'total'))
            <span class="badge" style="background:#EAF3F9;color:#0B3A63;font-weight:600;padding:6px 14px;border-radius:8px;font-size:0.82rem;">{{ $orders->total() }} Total Orders</span>
        @endif
    </div>
    @forelse($orders as $order)
    <div class="bg-white rounded-4 border p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <div class="fw-700 text-dark">#{{ $order->order_number }}</div>
                <div style="font-size:.8rem;color:#6c757d;">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                <div class="mt-1" style="font-size:.78rem;color:#475569;">
                    <span><i class="bi bi-wallet2 text-primary me-1"></i><strong>Payment:</strong> {{ $order->payment_method_name }}</span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                {!! $order->status_badge !!}
                {!! $order->payment_status_badge !!}
            </div>
        </div>
        <div class="d-flex gap-2 mt-3 flex-wrap">
            @foreach($order->items->take(4) as $item)
            <img src="{{ $item->image_url }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #e9ecef;">
            @endforeach
            @if($order->items->count() > 4)
            <div style="width:48px;height:48px;border-radius:8px;border:1px solid #e9ecef;display:flex;align-items:center;justify-content:center;font-size:.75rem;color:#6c757d;">+{{ $order->items->count() - 4 }}</div>
            @endif
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="fw-700" style="color:#0B3A63;font-size:1.1rem;">₹{{ number_format($order->total, 2) }}</div>
            <div class="d-flex gap-2">
                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm" style="background:#F0F7FD;color:#0B3A63;border:1px solid #D5E4F0;border-radius:10px;font-weight:600;font-size:.82rem;">View Details</a>
                @if($order->canBeCancelled())
                <form method="POST" action="{{ route('account.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order?')">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" style="border-radius:10px;font-size:.8rem;font-weight:600;">Cancel</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 bg-white rounded-4 border">
        <i class="bi bi-bag-x" style="font-size:3rem;color:#CBD5E1;display:block;"></i>
        <h6 class="mt-3 text-muted">No orders found</h6>
        <a href="{{ route('shop') }}" class="btn text-white mt-2 px-4" style="background:#D9232E;border-radius:12px;font-weight:600;"><i class="bi bi-cart3 me-1"></i> Start Shopping</a>
    </div>
    @endforelse
    {{ $orders->links() }}
</div>
</div>
@endsection
