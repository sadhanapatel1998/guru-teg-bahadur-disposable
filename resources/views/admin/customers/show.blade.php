{{-- resources/views/admin/customers/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'Customer Detail')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="fw-bold mb-1">Customer Detail</h4>
        <p class="text-muted mb-0">
            Complete customer information
        </p>
    </div>

    <a href="{{ route('admin.customers.index') }}"
       class="btn btn-dark">
        Back
    </a>

</div>

<div class="row g-4">

    {{-- Customer Info --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center p-4">

                <img
                    src="{{ $customer->avatar_url }}"
                    alt="{{ $customer->name }}"
                    width="110"
                    height="110"
                    class="rounded-circle border shadow-sm object-fit-cover mb-3"
                >

                <h4 class="fw-bold mb-1">
                    {{ $customer->name }}
                </h4>

                <p class="text-muted mb-3">
                    {{ $customer->email }}
                </p>

                @if($customer->is_active)

                    <span class="badge bg-success px-3 py-2">
                        Active
                    </span>

                @else

                    <span class="badge bg-danger px-3 py-2">
                        Inactive
                    </span>

                @endif

                <hr>

                <div class="text-start">

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Phone
                        </small>

                        <strong>
                            {{ $customer->phone ?? '-' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Gender
                        </small>

                        <strong>
                            {{ ucfirst($customer->gender ?? '-') }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Date of Birth
                        </small>

                        <strong>
                            {{ $customer->dob ? $customer->dob->format('d M Y') : '-' }}
                        </strong>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block">
                            Joined On
                        </small>

                        <strong>
                            {{ $customer->created_at->format('d M Y') }}
                        </strong>
                    </div>

                </div>

            </div>
        </div>

        {{-- Statistics --}}
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Statistics
                </h5>

                <div class="d-flex justify-content-between mb-3">
                    <span>Total Orders</span>

                    <strong>
                        {{ $customer->orders->count() }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Total Reviews</span>

                    <strong>
                        {{ $customer->reviews->count() }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Total Address</span>

                    <strong>
                        {{ $customer->addresses->count() }}
                    </strong>
                </div>

            </div>
        </div>

    </div>

    {{-- Orders + Addresses --}}
    <div class="col-lg-8">

        {{-- Orders --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">
                    Recent Orders
                </h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Order ID</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($customer->orders as $order)

                                <tr>

                                    <td class="px-4">
                                        #{{ $order->id }}
                                    </td>

                                    <td>
                                        ₹{{ number_format($order->total, 2) }}
                                    </td>

                                    <td>
                                        {{ ucfirst($order->payment_status) }}
                                    </td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No orders found
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Addresses --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">
                    Addresses
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    @forelse($customer->addresses as $address)

                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                @if($address->is_default)

                                    <span class="badge bg-success mb-2">
                                        Default
                                    </span>

                                @endif

                                <p class="mb-1 fw-semibold">
                                    {{ $address->name ?? $customer->name }}
                                </p>

                                <p class="text-muted mb-1">
                                    {{ $address->phone }}
                                </p>

                                <p class="mb-0 text-muted">
                                    {{ $address->address_line_1 ?? '' }},
                                    {{ $address->city ?? '' }},
                                    {{ $address->state ?? '' }}
                                    - {{ $address->pincode ?? '' }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">
                            <div class="text-muted">
                                No address found
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection