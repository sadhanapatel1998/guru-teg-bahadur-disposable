@php
    $backRoute = $backRoute ?? route('account.dashboard');
    $backLabel = $backLabel ?? 'Back to Dashboard';
    $currentTitle = $title ?? 'Account';
    $showMobileTabs = $showMobileTabs ?? true;
@endphp

{{-- 1. Desktop & Mobile Top Bar with Back & Home Buttons --}}
<div class="gtb-dash-topbar">
    <div class="gtb-dash-topbar-actions">
        <a href="{{ $backRoute }}" class="gtb-btn-back-dash">
            <i class="bi bi-arrow-left"></i>
            <span>{{ $backLabel }}</span>
        </a>
        <a href="{{ route('home') }}" class="gtb-btn-nav-home" title="Go to Homepage">
            <i class="bi bi-house-door"></i>
            <span class="d-none d-sm-inline">Home</span>
        </a>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb gtb-dash-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}">Dashboard</a></li>
            @if(isset($parentTitle) && isset($parentRoute))
                <li class="breadcrumb-item"><a href="{{ $parentRoute }}">{{ $parentTitle }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $currentTitle }}</li>
        </ol>
    </nav>
</div>

@if($showMobileTabs)
{{-- 2. Mobile Horizontal Scrollable Tabs (< 992px) --}}
<div class="gtb-mobile-tabs-wrap">
    <div class="gtb-mobile-tabs-scroll">
        <a href="{{ route('account.dashboard') }}" class="gtb-mobile-tab-pill {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('account.orders') }}" class="gtb-mobile-tab-pill {{ request()->routeIs('account.orders*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('account.profile') }}" class="gtb-mobile-tab-pill {{ request()->routeIs('account.profile') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
        <a href="{{ route('account.addresses') }}" class="gtb-mobile-tab-pill {{ request()->routeIs('account.addresses') ? 'active' : '' }}">
            <i class="bi bi-geo-alt"></i>
            <span>Addresses</span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="gtb-mobile-tab-pill {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
            <i class="bi bi-heart"></i>
            <span>Wishlist</span>
        </a>
    </div>
</div>
@endif

