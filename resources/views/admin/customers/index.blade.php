@extends('layouts.admin')

@section('title', 'Customers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Customers</h4>
        <p class="text-muted mb-0">
            Manage all registered customers
        </p>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search name, email, phone..."
                    >
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>

                        <option
                            value="active"
                            {{ request('status') == 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            {{ request('status') == 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Search
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('admin.customers.index') }}"
                       class="btn btn-light border w-100">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- Customers Table --}}
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($customers as $key => $customer)

                        <tr>

                            <td class="px-4">
                                {{ $customers->firstItem() + $key }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">

                                    <img
                                        src="{{ $customer->avatar_url }}"
                                        alt="{{ $customer->name }}"
                                        width="50"
                                        height="50"
                                        class="rounded-circle border object-fit-cover"
                                    >

                                    <div>
                                        <h6 class="mb-1 fw-semibold">
                                            {{ $customer->name }}
                                        </h6>

                                        <small class="text-muted">
                                            {{ $customer->email }}
                                        </small>
                                    </div>

                                </div>
                            </td>

                            <td>
                                {{ $customer->phone ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    {{ $customer->orders_count }}
                                </span>
                            </td>

                            <td>
                                @if($customer->is_active)

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
                                {{ $customer->created_at->format('d M Y') }}
                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                                       class="btn btn-sm btn-dark">
                                        View
                                    </a>

                                    {{-- Toggle Status --}}
                                    <form
                                        action="{{ route('admin.customers.toggle', $customer->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="btn btn-sm {{ $customer->is_active ? 'btn-danger' : 'btn-success' }}"
                                            onclick="return confirm('Are you sure?')"
                                        >
                                            {{ $customer->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No customers found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($customers->hasPages())

        <div class="card-footer bg-white border-0">
            {{ $customers->links() }}
        </div>

    @endif

</div>

@endsection