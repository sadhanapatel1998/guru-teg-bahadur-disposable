@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="py-5" style="background:#f8f9fa;min-height:70vh;">
<div class="container">
    <h5 class="fw-700 mb-4">My Orders</h5>
    @forelse($orders as $order)
    <div class="bg-white rounded-4 border p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <div class="fw-700">#{{ $order->order_number }}</div>
                <div style="font-size:.8rem;color:#6c757d;">{{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                {!! $order->status_badge !!}
                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->payment_status) }}</span>
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
            <div class="fw-700" style="color:var(--kkt-primary);">₹{{ number_format($order->total, 2) }}</div>
            <div class="d-flex gap-2">
                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.8rem;">View Details</a>
                @if($order->canBeCancelled())
                <form method="POST" action="{{ route('account.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order?')">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" style="border-radius:8px;font-size:.8rem;">Cancel</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 bg-white rounded-4 border">
        <i class="bi bi-bag-x" style="font-size:3rem;color:#e9ecef;display:block;"></i>
        <h6 class="mt-3 text-muted">No orders found</h6>
        <a href="{{ route('shop') }}" class="btn btn-primary mt-2">Start Shopping</a>
    </div>
    @endforelse
    {{ $orders->links() }}
</div>
</div>
@endsection
