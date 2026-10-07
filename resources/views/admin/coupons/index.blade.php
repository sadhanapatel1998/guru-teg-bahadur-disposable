@extends('layouts.admin')
@section('title', 'Coupons')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Coupons</h5>
        <p class="text-muted mb-0 small">
            Manage all discount coupons
        </p>
    </div>

    <a href="{{ route('admin.coupons.create') }}"
        class="btn btn-admin-primary text-white">
        <i class="bi bi-plus-circle me-1"></i>
        Add Coupon
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min Order</th>
                        <th>Max Discount</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Expiry</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($coupons as $coupon)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <span class="fw-semibold">
                                {{ $coupon->code }}
                            </span>

                            @if($coupon->description)
                                <div class="text-muted small">
                                    {{ $coupon->description }}
                                </div>
                            @endif
                        </td>

                        <td>
                            @if($coupon->type == 'percentage')
                                <span class="badge bg-info">
                                    Percentage
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    Fixed
                                </span>
                            @endif
                        </td>

                        <td class="fw-bold">
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ₹{{ number_format($coupon->value, 2) }}
                            @endif
                        </td>

                        <td>
                            ₹{{ number_format($coupon->min_order_amount, 2) }}
                        </td>

                        <td>
                            @if($coupon->max_discount_amount)
                                ₹{{ number_format($coupon->max_discount_amount, 2) }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            {{ $coupon->used_count }}
                            /
                            {{ $coupon->usage_limit ?? '∞' }}
                        </td>

                        <td>
                            @if($coupon->is_active)
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($coupon->starts_at)
                                {{ $coupon->starts_at->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('d M Y') }}
                            @else
                                Never
                            @endif
                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                   class="btn btn-sm btn-light border">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.coupons.destroy', $coupon) }}"
                                      onsubmit="return confirm('Delete this coupon?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="10"
                            class="text-center py-5 text-muted">
                            No coupons found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center p-3 border-top">

        <div class="small text-muted">
            Showing
            {{ $coupons->firstItem() }}
            to
            {{ $coupons->lastItem() }}
            of
            {{ $coupons->total() }}
            entries
        </div>

        {{ $coupons->links('pagination::bootstrap-5') }}

    </div>

</div>

@endsection