@php
    $currentCatSlug = $activeCategorySlug ?? request()->route('categorySlug');
    $activeFilterCount = 0;
    if (request('min_price')) $activeFilterCount++;
    if (request('max_price')) $activeFilterCount++;
    if (request('in_stock')) $activeFilterCount++;
    if (request('on_sale')) $activeFilterCount++;
    $resetUrl = $resetRoute ?? (isset($category) ? route('shop.category', $category->slug) : route('shop'));
@endphp

{{-- Filter Card Header (Desktop Only, Offcanvas has its own header) --}}
@if(!$isMobile)
<div class="gtb-filter-head">
    <div class="gtb-filter-head-title">
        <i class="bi bi-funnel-fill text-danger"></i>
        <span>Filters</span>
    </div>
    @if($activeFilterCount > 0)
        <a href="{{ $resetUrl }}" class="text-danger text-decoration-none fw-semibold" style="font-size:0.78rem;">
            Clear All
        </a>
    @endif
</div>
@endif

@if(request('q'))
<input type="hidden" name="q" value="{{ request('q') }}">
@endif
@if(request('sort') && request('sort') !== 'latest')
<input type="hidden" name="sort" value="{{ request('sort') }}">
@endif

{{-- 1. Categories --}}
<div class="mb-4">
    <label class="gtb-filter-heading">Categories</label>
    <div class="gtb-cat-list">
        {{-- All Products option --}}
        <a href="{{ route('shop') . (request('q') ? '?q=' . urlencode(request('q')) : '') }}" class="gtb-cat-item {{ !$currentCatSlug ? 'active' : '' }}">
            <span class="gtb-cat-name">
                <i class="bi bi-grid me-1.5 opacity-75"></i> All Products
            </span>
            <span class="gtb-cat-count">{{ $categories->sum('products_count') }}</span>
        </a>

        @foreach($categories as $cat)
        @php
            $catUrl = route('shop.category', $cat->slug) . (request('q') ? '?q=' . urlencode(request('q')) : '');
            $isCatActive = ($currentCatSlug === $cat->slug);
        @endphp
        <a href="{{ $catUrl }}" class="gtb-cat-item {{ $isCatActive ? 'active' : '' }}">
            <span class="gtb-cat-name text-truncate" style="max-width: 175px;" title="{{ $cat->name }}">
                {{ $cat->name }}
            </span>
            <span class="gtb-cat-count">{{ $cat->products_count }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- 2. Price Range --}}
<div class="mb-4">
    <label class="gtb-filter-heading">Price Range</label>
    <div class="d-flex align-items-center gap-2">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0 text-muted" style="font-size:0.8rem; font-weight:600;">₹</span>
            <input type="number" name="min_price" class="form-control form-control-sm border-start-0" placeholder="Min" value="{{ request('min_price') }}" min="0">
        </div>
        <span class="text-muted fw-bold">—</span>
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0 text-muted" style="font-size:0.8rem; font-weight:600;">₹</span>
            <input type="number" name="max_price" class="form-control form-control-sm border-start-0" placeholder="Max" value="{{ request('max_price') }}" min="0">
        </div>
    </div>
</div>

{{-- 3. Availability --}}
<div class="mb-4">
    <label class="gtb-filter-heading">Availability</label>
    <div class="d-flex flex-column gap-2">
        <label class="gtb-checkbox-label" for="in_stock_{{ $formId }}">
            <input class="form-check-input gtb-check-input mt-0" type="checkbox" name="in_stock" id="in_stock_{{ $formId }}" value="1" {{ request('in_stock') ? 'checked' : '' }}>
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-box-seam text-success"></i>
                <span>In Stock Only</span>
            </span>
        </label>
        <label class="gtb-checkbox-label" for="on_sale_{{ $formId }}">
            <input class="form-check-input gtb-check-input mt-0" type="checkbox" name="on_sale" id="on_sale_{{ $formId }}" value="1" {{ request('on_sale') ? 'checked' : '' }}>
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-tag-fill text-danger"></i>
                <span>On Sale / Deals</span>
            </span>
        </label>
    </div>
</div>

{{-- 4. Action Buttons --}}
<div class="d-flex flex-column gap-2 pt-2">
    <button type="submit" class="btn gtb-btn-apply-filters w-100">
        <i class="bi bi-check2-circle me-1"></i> Apply Filters
    </button>
    <a href="{{ $resetUrl }}" class="btn gtb-btn-reset-filters w-100">
        <i class="bi bi-arrow-counterclockwise me-1"></i> {{ request('q') ? 'Reset Filters & Search' : 'Reset' }}
    </a>
</div>

