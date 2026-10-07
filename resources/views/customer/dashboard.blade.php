@extends('layouts.app')
@section('title', 'My Account')
@section('content')
<div class="py-5" style="background:#f8f9fa;min-height:70vh;">
<div class="container">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="p-4 bg-white rounded-4 border">
                <div class="text-center mb-4">
                    <img src="{{ auth()->user()->avatar_url }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid var(--kkt-light);">
                    <div class="fw-700 mt-2">{{ auth()->user()->name }}</div>
                    <div style="font-size:.8rem;color:#6c757d;">{{ auth()->user()->email }}</div>
                </div>
                <nav class="d-flex flex-column gap-1">
                    @foreach([
                        ['route' => 'account.dashboard', 'icon' => 'speedometer2', 'label' => 'Dashboard'],
                        ['route' => 'account.orders',    'icon' => 'box',          'label' => 'My Orders'],
                        ['route' => 'account.profile',   'icon' => 'person',       'label' => 'Profile'],
                        ['route' => 'account.addresses', 'icon' => 'geo-alt',      'label' => 'Addresses'],
                        ['route' => 'wishlist.index',    'icon' => 'heart',        'label' => 'Wishlist'],
                    ] as $item)
                    <a href="{{ route($item['route']) }}" class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none {{ request()->routeIs($item['route']) ? 'fw-700' : '' }}"
                       style="font-size:.88rem;color:{{ request()->routeIs($item['route']) ? 'var(--kkt-primary)' : '#555' }};background:{{ request()->routeIs($item['route']) ? 'var(--kkt-light)' : 'transparent' }};">
                        <i class="bi bi-{{ $item['icon'] }}"></i> {{ $item['label'] }}
                    </a>
                    @endforeach
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 w-100 text-start border-0 bg-transparent" style="font-size:.88rem;color:#dc3545;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        {{-- Main --}}
        <div class="col-lg-9">
            {{-- Stats --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 text-center" style="background:linear-gradient(135deg,#0b6b57,#6dc242);color:#fff;border:none;box-shadow:0 12px 30px rgba(11,107,87,.18);">
                        <div  style="font-size:2rem;font-weight:800;color:#fff;">{{ $totalOrders }}</div>
                        <div style="font-size:.84rem;color:rgba(255,255,255,.85);">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border text-center" style="background:linear-gradient(135deg,#0b6b57,#6dc242);color:#fff;border:none;box-shadow:0 12px 30px rgba(11,107,87,.18);">
                        <div style="font-size:2rem;font-weight:800;color:#fff;">₹{{ number_format($totalSpent, 0) }}</div>
                        <div style="font-size:.84rem;color:rgba(255,255,255,.85);">Total Spent</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border text-center" style="background:linear-gradient(135deg,#0b6b57,#6dc242);color:#fff;border:none;box-shadow:0 12px 30px rgba(11,107,87,.18);">
                        <div style="font-size:2rem;font-weight:800;color:#fff;">{{ $wishlistCount }}</div>
                        <div style="font-size:.84rem;color:rgba(255,255,255,.85);">Wishlist Items</div>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-white rounded-4 border overflow-hidden">
                <div class="p-4 border-bottom d-flex justify-content-between">
                    <h6 class="fw-700 mb-0">Recent Orders</h6>
                    <a href="{{ route('account.orders') }}" style="font-size:.84rem;color:var(--kkt-primary);">View All</a>
                </div>
                @forelse($recentOrders as $order)
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <div>
                        <div class="fw-600" style="font-size:.9rem;">#{{ $order->order_number }}</div>
                        <div style="font-size:.78rem;color:#6c757d;">{{ $order->created_at->format('d M Y') }} · {{ $order->items->count() }} items</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-700" style="color:var(--kkt-primary);">₹{{ number_format($order->total, 2) }}</div>
                        {!! $order->status_badge !!}
                    </div>
                    <a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.78rem;">View</a>
                </div>
                @empty
                <div class="p-5 text-center text-muted">No orders yet. <a href="{{ route('shop') }}">Start shopping!</a></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
@endsection
