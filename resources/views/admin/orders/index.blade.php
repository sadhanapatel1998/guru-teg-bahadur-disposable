@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-700 mb-0">Orders</h5>
</div>

<div class="form-card mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Order # or customer name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                @foreach(['pending','confirmed','processing','shipped','out_for_delivery','delivered','cancelled','returned','refunded'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="payment" class="form-select form-select-sm">
                <option value="">Payment Status</option>
                <option value="pending" {{ request('payment') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('payment') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ request('payment') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-1">
            <button class="btn btn-sm btn-admin-primary text-white w-100">Go</button>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <span>{{ $orders->total() }} Orders</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Order #</th><th>Customer</th><th>Items</th>
                    <th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong style="font-size:.88rem;">{{ $order->order_number }}</strong></td>
                    <td>
                        <div style="font-size:.87rem;font-weight:600;">{{ $order->shipping_name }}</div>
                        <div style="font-size:.76rem;color:#6c757d;">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td style="font-size:.84rem;">{{ $order->items->count() }} item(s)</td>
                    <td style="font-weight:700;color:#2E6F40;">₹{{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : ($order->payment_status === 'failed' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        <div style="font-size:.72rem;color:#6c757d;">{{ strtoupper($order->payment_method) }}</div>
                    </td>
                    <td>{!! $order->status_badge !!}</td>
                    <td style="font-size:.82rem;color:#6c757d;">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-xs btn-light" style="font-size:.75rem;padding:3px 10px;border-radius:6px;">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="d-flex justify-content-center py-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
