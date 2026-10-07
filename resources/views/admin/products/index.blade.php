@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">Products</h5>
        <p class="text-muted mb-0" style="font-size:.85rem;">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary text-white">
        <i class="bi bi-plus-circle me-2"></i>Add Product
    </a>
</div>

{{-- Filters --}}
<div class="form-card mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name or SKU..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-admin-primary text-white">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <span>{{ $products->total() }} Products</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Product</th><th>SKU</th><th>Category</th>
                    <th>Price</th><th>Stock</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $product->thumbnail_url }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;" alt="{{ $product->name }}">
                            <div>
                                <div style="font-size:.88rem;font-weight:600;">{{ Str::limit($product->name, 35) }}</div>
                                @if($product->is_featured)<span class="badge bg-warning text-dark me-1" style="font-size:.65rem;">Featured</span>@endif
                                @if($product->is_trending)<span class="badge bg-info" style="font-size:.65rem;">Trending</span>@endif
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.82rem;color:#6c757d;">{{ $product->sku }}</td>
                    <td style="font-size:.84rem;">{{ optional($product->category)->name }}</td>
                    <td>
                        <div style="font-weight:700;font-size:.9rem;color:#2E6F40;">₹{{ number_format($product->effective_price, 2) }}</div>
                        @if($product->sale_price)
                        <div style="font-size:.76rem;text-decoration:line-through;color:#6c757d;">₹{{ number_format($product->price, 2) }}</div>
                        @endif
                    </td>
                    <td>
                        @if(!$product->manage_stock)
                            <span class="badge bg-success" style="font-size:.72rem;">Unlimited</span>
                        @elseif($product->stock === 0)
                            <span class="badge bg-danger" style="font-size:.72rem;">Out of Stock</span>
                        @elseif($product->isLowStock())
                            <span class="badge bg-warning text-dark" style="font-size:.72rem;">Low: {{ $product->stock }}</span>
                        @else
                            <span class="badge bg-success" style="font-size:.72rem;">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->status === 'active' ? 'bg-success' : ($product->status === 'draft' ? 'bg-secondary' : 'bg-danger') }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-xs btn-light" style="font-size:.75rem;padding:3px 8px;border-radius:6px;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-xs btn-light" style="font-size:.75rem;padding:3px 8px;border-radius:6px;" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-danger" style="font-size:.75rem;padding:3px 8px;border-radius:6px;" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">We couldn’t find any products in this category or subcategory.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
   
         {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div class="text-muted small mx-3">
                        Showing
                        {{ $products->firstItem() }}
                        to
                        {{ $products->lastItem() }}
                        of
                        {{ $products->total() }}
                        entries
                    </div>

                    {{ $products->links('pagination::bootstrap-5') }}

                </div>
</div>
@endsection
