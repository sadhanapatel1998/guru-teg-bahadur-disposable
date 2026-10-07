@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house-door-fill me-1"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Shop
                </li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <div class="row g-4">
            {{-- Sidebar Filters --}}
            <div class="col-lg-3">
                <div class="p-4 bg-white rounded-4 border" style="position:sticky;top:80px;">
                    <h6 class="fw-700 mb-4">Filters</h6>
                    <form method="GET" id="filter-form">
                        {{-- Categories --}}
                        <div class="mb-4">
                            <div class="fw-600 mb-2" style="font-size:.88rem;">Categories</div>
                            @foreach($categories as $cat)
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <a href="{{ route('shop.category', $cat->slug) }}" class="text-decoration-none" style="font-size:.85rem;color:{{ request()->route()->getName() === 'shop.category' && request()->route('categorySlug') === $cat->slug ? 'var(--kkt-primary)' : '#555' }};font-weight:{{ request()->route('categorySlug') === $cat->slug ? '700' : '400' }};">{{ $cat->name }}</a>
                                <span style="font-size:.72rem;color:#aaa;">{{ $cat->products_count }}</span>
                            </div>
                            @endforeach
                        </div>

                        {{-- Price Range --}}
                        <div class="mb-4">
                            <div class="fw-600 mb-2" style="font-size:.88rem;">Price Range</div>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                                <span>—</span>
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        {{-- Availability --}}
                        <div class="mb-4">
                            <div class="fw-600 mb-2" style="font-size:.88rem;">Availability</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}>
                                <label class="form-check-label" for="in_stock" style="font-size:.84rem;">In Stock Only</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="on_sale" id="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}>
                                <label class="form-check-label" for="on_sale" style="font-size:.84rem;">On Sale</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-sm">Apply Filters</button>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 btn-sm mt-2">Reset</a>
                    </form>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted" style="font-size:.88rem;">{{ $products->total() }} products found</span>
                    <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()" form="filter-form">
                        <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>

                @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size:3rem;color:#e9ecef;display:block;"></i>
                    <h5 class="mt-3 text-muted">We couldn’t find any products in this category or subcategory. </h5>
                    <a href="{{ route('shop') }}" class="btn btn-primary mt-2">Browse All</a>
                </div>
                @else
                <div class="row g-3">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
