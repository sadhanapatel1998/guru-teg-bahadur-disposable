@extends('layouts.app')
@section('title', $category->name . (request('q') ? ' - Search: "' . request('q') . '"' : ''))

@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav>
            <ol class="breadcrumb mb-0" style="font-size:.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                @if(request('q'))
                <li class="breadcrumb-item"><a href="{{ route('shop.category', $category->slug) }}">{{ $category->name }}</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:250px;">Search: &ldquo;{{ request('q') }}&rdquo;</li>
                @else
                <li class="breadcrumb-item active">{{ $category->name }}</li>
                @endif
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        @php
            $activeFilterCount = 0;
            if (request('min_price')) $activeFilterCount++;
            if (request('max_price')) $activeFilterCount++;
            if (request('in_stock')) $activeFilterCount++;
            if (request('on_sale')) $activeFilterCount++;
        @endphp

        {{-- Mobile Sliding Filter Sidebar / Offcanvas (< 992px) --}}
        <div class="offcanvas offcanvas-start gtb-filter-offcanvas d-lg-none" tabindex="-1" id="mobileFilterDrawer" aria-labelledby="mobileFilterDrawerLabel">
            <div class="offcanvas-header border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-funnel-fill text-danger fs-5"></i>
                    <h5 class="offcanvas-title fw-bold text-dark mb-0" id="mobileFilterDrawerLabel">Filters</h5>
                    @if($activeFilterCount > 0)
                        <span class="badge bg-danger rounded-pill" style="font-size:0.72rem;">{{ $activeFilterCount }} active</span>
                    @endif
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-4">
                <form method="GET" action="{{ route('shop.category', $category->slug) }}" id="mobile-filter-form">
                    @include('frontend.products.partials.filter-content', [
                        'formId' => 'mobile',
                        'isMobile' => true,
                        'activeCategorySlug' => $category->slug,
                        'resetRoute' => route('shop.category', $category->slug)
                    ])
                </form>
            </div>
        </div>

        <div class="row g-4">
            {{-- Desktop Sidebar Filters (Visible >= 992px) --}}
            <div class="col-lg-3 d-none d-lg-block">
                <div class="gtb-filter-card" style="position:sticky;top:130px;">
                    <form method="GET" action="{{ route('shop.category', $category->slug) }}" id="desktop-filter-form">
                        @include('frontend.products.partials.filter-content', [
                            'formId' => 'desktop',
                            'isMobile' => false,
                            'activeCategorySlug' => $category->slug,
                            'resetRoute' => route('shop.category', $category->slug)
                        ])
                    </form>
                </div>
            </div>

            {{-- Products Grid Column --}}
            <div class="col-lg-9">
                @if(request('q'))
                <div class="alert bg-white border rounded-4 p-3 mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2 shadow-sm" style="border-left: 4px solid var(--gtb-red, #D9232E) !important;">
                    <div>
                        <span class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.8px; font-weight:600;">Search in {{ $category->name }}</span>
                        <h5 class="mb-0 fw-bold text-dark mt-1">&ldquo;{{ request('q') }}&rdquo;</h5>
                    </div>
                    <a href="{{ route('shop.category', $category->slug) }}" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 rounded-pill px-3">
                        <i class="bi bi-x-circle"></i> Clear Search
                    </a>
                </div>
                @endif

                {{-- Toolbar: Product Count & Filter/Sort Controls --}}
                <div class="bg-white rounded-4 border p-3 mb-4 shadow-sm">
                    {{-- Mobile Status Row (< 992px) --}}
                    <div class="d-flex d-lg-none align-items-center justify-content-between mb-2.5 pb-2 border-bottom">
                        <span class="text-muted" style="font-size:0.84rem; font-family:'Poppins', sans-serif;">
                            Showing <strong class="text-dark">{{ $products->total() }}</strong> {{ Str::plural('product', $products->total()) }}
                        </span>
                        @if($activeFilterCount > 0)
                            <a href="{{ route('shop.category', $category->slug) }}" class="text-danger text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-x-circle"></i> Clear ({{ $activeFilterCount }})
                            </a>
                        @endif
                    </div>

                    {{-- Mobile 2-Column Symmetrical Actions Grid (< 992px) --}}
                    <div class="d-lg-none gtb-mobile-toolbar-grid">
                        <button type="button" class="btn gtb-mobile-filter-trigger" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterDrawer" aria-controls="mobileFilterDrawer">
                            <i class="bi bi-sliders2"></i>
                            <span>Filters</span>
                            @if($activeFilterCount > 0)
                                <span class="badge bg-danger rounded-pill">{{ $activeFilterCount }}</span>
                            @endif
                        </button>

                        <select name="sort" class="form-select gtb-sort-select" onchange="applySortChange(this.value)">
                            <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>Sort: Latest</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>

                    {{-- Desktop Toolbar (>= 992px) --}}
                    <div class="d-none d-lg-flex align-items-center justify-content-between">
                        <span class="text-muted" style="font-size:0.9rem; font-family:'Poppins', sans-serif;">
                            <strong class="text-dark">{{ $products->total() }}</strong> {{ Str::plural('product', $products->total()) }} found
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small mb-0" style="font-size:0.84rem; white-space:nowrap;">Sort by:</label>
                            <select name="sort" class="form-select form-select-sm gtb-sort-select" style="width:170px;" onchange="applySortChange(this.value)">
                                <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                    </div>
                </div>

                @if($products->isEmpty())
                <div class="text-center py-5 bg-white rounded-4 border p-4">
                    <i class="bi bi-search" style="font-size:3rem;color:#cbd5e1;display:block;"></i>
                    <h5 class="mt-3 text-dark fw-bold">
                        @if(request('q'))
                            No products found matching &ldquo;{{ request('q') }}&rdquo; in {{ $category->name }}.
                        @else
                            We couldn’t find any products in this category.
                        @endif
                    </h5>
                    <p class="text-muted mb-3" style="font-size:0.9rem;">
                        @if(request('q'))
                            Try checking your spelling, or searching across all categories.
                        @else
                            Try adjusting your filters or checking back soon.
                        @endif
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        @if(request('q') || request('min_price') || request('max_price') || request('in_stock') || request('on_sale'))
                        <a href="{{ route('shop.category', $category->slug) }}" class="btn btn-outline-secondary">Clear Filters</a>
                        @endif
                        <a href="{{ route('shop') }}" class="btn btn-primary">Browse All Products</a>
                    </div>
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

@push('scripts')
<script>
function applySortChange(sortVal) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortVal);
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
}
</script>
@endpush
@endsection
