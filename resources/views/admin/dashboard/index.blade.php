@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stat Cards Row --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Today's Revenue</div>
                    <div class="stat-value">₹{{ number_format($todayRevenue, 0) }}</div>
                    <small class="text-muted">Month: ₹{{ number_format($monthRevenue, 0) }}</small>
                </div>
                <div class="stat-icon" style="background:#e8f5e9;color:#2E6F40;">
                    <i class="bi bi-currency-rupee"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">{{ number_format($totalOrders) }}</div>
                    <small class="text-warning">{{ $pendingOrders }} pending</small>
                </div>
                <div class="stat-icon" style="background:#fff3e0;color:#f57c00;">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Customers</div>
                    <div class="stat-value">{{ number_format($totalCustomers) }}</div>
                    <small class="text-success">+{{ $newCustomers }} this month</small>
                </div>
                <div class="stat-icon" style="background:#e3f2fd;color:#1976d2;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Products</div>
                    <div class="stat-value">{{ number_format($totalProducts) }}</div>
                    <small class="text-danger">{{ $outOfStock }} out of stock</small>
                </div>
                <div class="stat-icon" style="background:#fce4ec;color:#c62828;">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Revenue Chart --}}
    <div class="col-xl-8">
        <div class="table-card">
            <div class="table-card-header">
                <span><i class="bi bi-graph-up me-2" style="color:var(--admin-primary);"></i>Revenue Overview (Last 12 Months)</span>
            </div>
            <div style="padding: 20px;">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Order Status Breakdown --}}
    <div class="col-xl-4">
        <div class="table-card h-100">
            <div class="table-card-header">
                <span><i class="bi bi-pie-chart me-2" style="color:var(--admin-primary);"></i>Order Status</span>
            </div>
            <div style="padding: 20px;">
                <canvas id="orderChart"></canvas>
            </div>
            <div style="padding: 0 20px 20px;">
                <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted" style="font-size:.83rem;">Pending</span><span class="badge bg-warning text-dark">{{ $pendingOrders }}</span></div>
                <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted" style="font-size:.83rem;">Processing</span><span class="badge bg-primary">{{ $processingOrders }}</span></div>
                <div class="d-flex justify-content-between py-2"><span class="text-muted" style="font-size:.83rem;">Delivered</span><span class="badge bg-success">{{ $deliveredOrders }}</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Orders --}}
    <div class="col-xl-8">
        <div class="table-card">
            <div class="table-card-header">
                <span><i class="bi bi-receipt me-2" style="color:var(--admin-primary);"></i>Recent Orders</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order #</th><th>Customer</th><th>Amount</th><th>Payment</th><th>Status</th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>{!! $order->status_badge !!}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-xs btn-light" style="font-size:.75rem;padding:2px 8px;border-radius:6px;">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-xl-4">
        <div class="table-card">
            <div class="table-card-header">
                <span><i class="bi bi-trophy me-2" style="color:var(--admin-primary);"></i>Top Products</span>
            </div>
            <div style="padding: 16px;">
                @foreach($topProducts as $p)
                <div class="d-flex gap-3 align-items-center mb-3">
                    <img src="{{ $p->thumbnail ? asset('public/storage/'.$p->thumbnail) : asset('images/no-image.png') }}"
                         style="width:44px;height:44px;border-radius:8px;object-fit:cover;" alt="{{ $p->name }}">
                    <div class="flex-grow-1">
                        <div style="font-size:.85rem;font-weight:600;">{{ Str::limit($p->name, 28) }}</div>
                        <div style="font-size:.75rem;color:#6c757d;">{{ $p->total_sold }} sold</div>
                    </div>
                    <div style="font-size:.88rem;font-weight:700;color:var(--admin-primary);">₹{{ number_format($p->revenue, 0) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Revenue Chart
const months = {!! json_encode($monthlyRevenue->map(fn($m) => date('M Y', mktime(0,0,0,$m->month,1,$m->year)))) !!};
const revenues = {!! json_encode($monthlyRevenue->pluck('revenue')) !!};

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue (₹)',
            data: revenues,
            borderColor: '#2E6F40',
            backgroundColor: 'rgba(46,111,64,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#2E6F40',
            tension: 0.4,
            fill: true
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => '₹' + v.toLocaleString() } } } }
});

// Order Status Doughnut
new Chart(document.getElementById('orderChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Processing', 'Delivered'],
        datasets: [{ data: [{{ $pendingOrders }}, {{ $processingOrders }}, {{ $deliveredOrders }}], backgroundColor: ['#ffc107','#0d6efd','#198754'], borderWidth: 0 }]
    },
    options: { cutout: '70%', plugins: { legend: { display: false } } }
});
</script>
@endpush
