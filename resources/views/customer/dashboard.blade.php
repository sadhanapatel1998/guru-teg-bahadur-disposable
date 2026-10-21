@extends('layouts.app')
@section('title', 'My Account - Dashboard')

@push('styles')
<style>
/* ============================================================
   GTB LUXURY CUSTOMER DASHBOARD (MATCHING LOGO COLORS)
   Primary: Deep Navy (#0B3A63) | Secondary: Vibrant Red (#D9232E)
   Background: #F8FAFC | Surface: #FFFFFF
============================================================ */
.gtb-dashboard-page {
    background: #F8FAFC;
    min-height: 75vh;
}

/* 1. Welcome Header Banner */
.gtb-welcome-banner {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    padding: 22px 28px;
    box-shadow: 0 4px 20px rgba(11, 58, 99, 0.03);
    margin-bottom: 24px;
}

.gtb-welcome-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #0B3A63;
    margin-bottom: 4px;
    letter-spacing: -0.3px;
}

.gtb-welcome-sub {
    font-size: 0.88rem;
    color: #64748B;
    margin: 0;
}

.gtb-member-pill {
    display: inline-flex;
    align-items: center;
    background: #EAF3F9;
    color: #0B3A63;
    border: 1px solid #D5E4F0;
    font-family: 'Poppins', sans-serif;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 50px;
    letter-spacing: 0.2px;
}

.gtb-banner-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #D9232E;
    color: #FFFFFF !important;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(217, 35, 46, 0.25);
    transition: all 0.25s ease;
}

.gtb-banner-cta:hover {
    background: #B71923;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(217, 35, 46, 0.35);
}

/* 2. Customer Sidebar Card */
.gtb-dash-sidebar {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    padding: 24px 20px;
    box-shadow: 0 4px 20px rgba(11, 58, 99, 0.04);
}

.gtb-avatar-ring {
    position: relative;
    width: 82px;
    height: 82px;
    margin: 0 auto 12px;
}

.gtb-avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #FFFFFF;
    box-shadow: 0 6px 18px rgba(11, 58, 99, 0.16);
}

.gtb-user-name {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #0B3A63;
    margin-bottom: 2px;
}

.gtb-user-email {
    font-size: 0.8rem;
    color: #64748B;
    word-break: break-all;
    margin-bottom: 10px;
}

/* Sidebar Nav Links */
.gtb-dash-nav {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
}

.gtb-dash-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 16px;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 500;
    color: #334155 !important;
    text-decoration: none !important;
    transition: all 0.22s ease;
}

.gtb-dash-nav-link .nav-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.gtb-dash-nav-link .nav-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    background: #F1F5F9;
    color: #64748B;
    transition: all 0.22s ease;
}

.gtb-dash-nav-link:hover {
    background: #F0F7FD;
    color: #0B3A63 !important;
    transform: translateX(3px);
}

.gtb-dash-nav-link:hover .nav-icon {
    background: #E0F0FA;
    color: #0B3A63;
}

.gtb-dash-nav-link.active {
    background: linear-gradient(135deg, #0B3A63 0%, #072642 100%) !important;
    color: #FFFFFF !important;
    font-weight: 600;
    box-shadow: 0 6px 18px rgba(11, 58, 99, 0.22);
}

.gtb-dash-nav-link.active .nav-icon {
    background: rgba(255, 255, 255, 0.18) !important;
    color: #FFFFFF !important;
}

.gtb-dash-nav-link .nav-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
}

.gtb-dash-nav-link.active .nav-badge {
    background: rgba(255, 255, 255, 0.2) !important;
    color: #FFFFFF !important;
}

.gtb-dash-nav-link.nav-logout {
    color: #DC2626 !important;
}

.gtb-dash-nav-link.nav-logout .nav-icon {
    background: #FEF2F2;
    color: #DC2626;
}

.gtb-dash-nav-link.nav-logout:hover {
    background: #FEE2E2;
    color: #B91C1C !important;
}

/* Mobile Quick Navigation Tabs (< 992px) */
.gtb-mobile-tabs-wrap {
    display: none;
    margin-bottom: 20px;
}

@media (max-width: 991.98px) {
    .gtb-mobile-tabs-wrap {
        display: block;
    }

    .gtb-mobile-tabs-scroll {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .gtb-mobile-tabs-scroll::-webkit-scrollbar {
        display: none;
    }

    .gtb-mobile-tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        padding: 9px 16px;
        border-radius: 50px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #334155;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
    }

    .gtb-mobile-tab-pill.active {
        background: #0B3A63;
        color: #FFFFFF;
        border-color: #0B3A63;
        box-shadow: 0 4px 12px rgba(11, 58, 99, 0.25);
    }
}

/* 3. Luxury Stats Cards (Matching Logo Color Scheme) */
.gtb-stat-card {
    position: relative;
    border-radius: 20px;
    padding: 24px 22px;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease;
    min-height: 154px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.gtb-stat-card:hover {
    transform: translateY(-4px);
}

/* Card 1: Navy Blue Theme (Primary Logo Color) */
.gtb-stat-orders {
    background: linear-gradient(135deg, #0B3A63 0%, #072A48 100%);
    color: #FFFFFF;
    box-shadow: 0 12px 28px rgba(11, 58, 99, 0.20);
    border: none;
}

.gtb-stat-orders:hover {
    box-shadow: 0 16px 36px rgba(11, 58, 99, 0.30);
}

/* Card 2: Crimson Red Theme (Secondary Logo Color) */
.gtb-stat-spent {
    background: linear-gradient(135deg, #D9232E 0%, #B71923 100%);
    color: #FFFFFF;
    box-shadow: 0 12px 28px rgba(217, 35, 46, 0.22);
    border: none;
}

.gtb-stat-spent:hover {
    box-shadow: 0 16px 36px rgba(217, 35, 46, 0.32);
}

/* Card 3: Crisp Pure White Card with Red & Navy Accents */
.gtb-stat-wishlist {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    color: #1E293B;
}

.gtb-stat-wishlist:hover {
    border-color: rgba(217, 35, 46, 0.35);
    box-shadow: 0 14px 32px rgba(217, 35, 46, 0.10);
}

/* Watermark Background Icon */
.gtb-stat-watermark {
    position: absolute;
    right: -10px;
    bottom: -15px;
    font-size: 5.5rem;
    line-height: 1;
    pointer-events: none;
    user-select: none;
}

.gtb-stat-orders .gtb-stat-watermark {
    color: rgba(255, 255, 255, 0.07);
}

.gtb-stat-spent .gtb-stat-watermark {
    color: rgba(255, 255, 255, 0.09);
}

.gtb-stat-wishlist .gtb-stat-watermark {
    color: rgba(217, 35, 46, 0.04);
}

/* Stat Card Top Row */
.gtb-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.gtb-stat-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.gtb-stat-orders .gtb-stat-icon-wrap {
    background: rgba(255, 255, 255, 0.18);
    color: #FFFFFF;
}

.gtb-stat-spent .gtb-stat-icon-wrap {
    background: rgba(255, 255, 255, 0.20);
    color: #FFFFFF;
}

.gtb-stat-wishlist .gtb-stat-icon-wrap {
    background: #FFF0F1;
    color: #D9232E;
}

.gtb-stat-tag {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}

.gtb-stat-orders .gtb-stat-tag {
    background: rgba(255, 255, 255, 0.16);
    color: #FFFFFF;
}

.gtb-stat-spent .gtb-stat-tag {
    background: rgba(255, 255, 255, 0.18);
    color: #FFFFFF;
}

.gtb-stat-wishlist .gtb-stat-tag {
    background: #EEF5FA;
    color: #0B3A63;
}

/* Stat Body Values */
.gtb-stat-mid {
    position: relative;
    z-index: 2;
    margin: 14px 0 6px;
}

.gtb-stat-num {
    font-family: 'Poppins', sans-serif;
    font-size: 2.3rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -1px;
    margin-bottom: 4px;
}

.gtb-stat-orders .gtb-stat-num,
.gtb-stat-spent .gtb-stat-num {
    color: #FFFFFF;
}

.gtb-stat-wishlist .gtb-stat-num {
    color: #0B3A63;
}

.gtb-stat-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
}

.gtb-stat-orders .gtb-stat-label,
.gtb-stat-spent .gtb-stat-label {
    color: rgba(255, 255, 255, 0.9);
}

.gtb-stat-wishlist .gtb-stat-label {
    color: #64748B;
}

/* Stat Card Bottom Footer */
.gtb-stat-foot {
    position: relative;
    z-index: 2;
    font-size: 12px;
}

.gtb-stat-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none !important;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    transition: all 0.2s ease;
}

.gtb-stat-orders .gtb-stat-link {
    color: rgba(255, 255, 255, 0.9);
}

.gtb-stat-orders .gtb-stat-link:hover {
    color: #FFFFFF;
    transform: translateX(3px);
}

.gtb-stat-spent .gtb-stat-foot span {
    color: rgba(255, 255, 255, 0.85);
}

.gtb-stat-wishlist .gtb-stat-link {
    color: #D9232E;
}

.gtb-stat-wishlist .gtb-stat-link:hover {
    color: #B71923;
    transform: translateX(3px);
}

/* 4. Recent Orders Luxury Card */
.gtb-orders-panel {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(11, 58, 99, 0.04);
    overflow: hidden;
}

.gtb-orders-header {
    padding: 22px 26px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.gtb-orders-header-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.18rem;
    font-weight: 700;
    color: #0B3A63;
    margin-bottom: 2px;
}

.gtb-orders-header-sub {
    font-size: 0.82rem;
    color: #64748B;
    margin: 0;
}

.gtb-btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #EEF5FA;
    color: #0B3A63 !important;
    border: 1px solid #D5E4F0;
    border-radius: 12px;
    padding: 8px 18px;
    font-family: 'Poppins', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.22s ease;
}

.gtb-btn-view-all:hover {
    background: #0B3A63;
    color: #FFFFFF !important;
    border-color: #0B3A63;
    transform: translateY(-1px);
}

/* Order Item Row */
.gtb-order-row {
    padding: 20px 26px;
    border-bottom: 1px solid #F1F5F9;
    transition: background-color 0.2s ease;
}

.gtb-order-row:last-child {
    border-bottom: none;
}

.gtb-order-row:hover {
    background: #F8FAFC;
}

.gtb-order-num {
    font-family: 'Poppins', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 4px;
}

.gtb-order-meta {
    font-size: 0.8rem;
    color: #64748B;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.gtb-order-thumbs {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
}

.gtb-order-thumb {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #E2E8F0;
    background: #F1F5F9;
}

.gtb-order-thumb-more {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    border: 1px dashed #CBD5E1;
    background: #F8FAFC;
    color: #64748B;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.gtb-order-price {
    font-family: 'Poppins', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #0B3A63;
    margin-bottom: 4px;
}

/* Status Badges */
.gtb-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-family: 'Poppins', sans-serif;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 50px;
    letter-spacing: 0.2px;
}

.gtb-status-confirmed {
    background: #DEF7EC;
    color: #03543F;
}

.gtb-status-pending {
    background: #FEF3C7;
    color: #92400E;
}

.gtb-status-processing {
    background: #E0F2FE;
    color: #075985;
}

.gtb-status-shipped {
    background: #F3E8FF;
    color: #6B21A8;
}

.gtb-status-delivered {
    background: #DEF7EC;
    color: #03543F;
}

.gtb-status-cancelled {
    background: #FDE8E8;
    color: #9B1C1C;
}

.gtb-status-default {
    background: #F1F5F9;
    color: #475569;
}

.gtb-btn-view-order {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #F0F7FD;
    color: #0B3A63 !important;
    border: 1px solid #D5E4F0;
    border-radius: 10px;
    padding: 7px 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.gtb-btn-view-order:hover {
    background: #0B3A63;
    color: #FFFFFF !important;
    border-color: #0B3A63;
    transform: translateY(-1px);
}

/* 5. Empty State */
.gtb-empty-orders {
    padding: 55px 20px;
    text-align: center;
}

.gtb-empty-icon {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #EEF5FA;
    color: #0B3A63;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 16px;
}

.gtb-empty-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #0B3A63;
    margin-bottom: 4px;
}

.gtb-empty-desc {
    font-size: 0.88rem;
    color: #64748B;
    max-width: 380px;
    margin: 0 auto 20px;
}

/* 6. Bottom Trust / Assurance Row */
.gtb-account-trust-strip {
    display: none;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 18px;
    padding: 18px 24px;
    margin-top: 24px;
}

.gtb-trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.gtb-trust-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.gtb-trust-navy {
    background: #EAF3F9;
    color: #0B3A63;
}

.gtb-trust-red {
    background: #FFF0F1;
    color: #D9232E;
}

.gtb-trust-green {
    background: #DEF7EC;
    color: #16A34A;
}

.gtb-trust-content h6 {
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    color: #0B3A63;
    margin: 0;
}

.gtb-trust-content span {
    font-size: 11.5px;
    color: #64748B;
}

/* Responsive Tweaks */
@media (max-width: 767.98px) {
    .gtb-welcome-banner {
        padding: 16px 18px;
    }

    .gtb-welcome-title {
        font-size: 1.2rem;
    }

    .gtb-stat-card {
        min-height: 140px;
        padding: 18px 18px;
    }

    .gtb-stat-num {
        font-size: 1.9rem;
    }

    .gtb-orders-header {
        padding: 16px 18px;
    }

    .gtb-order-row {
        padding: 16px 18px;
    }
}
</style>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb-kkt">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.84rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </nav>
    </div>
</div>

<div class="gtb-dashboard-page py-4 py-lg-5">
    <div class="container">

        {{-- 1. Welcome Greeting Banner --}}
        <div class="gtb-welcome-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-sm-block">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                        style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2.5px solid #0B3A63;">
                </div>
                <div>
                    <h1 class="gtb-welcome-title">
                        Welcome back, {{ auth()->user()->name }} <span class="d-inline-block">👋</span>
                    </h1>
                    <p class="gtb-welcome-sub">
                        Manage your orders, saved addresses, and profile details all in one place.
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="gtb-btn-nav-home" title="Go to Homepage">
                    <i class="bi bi-house-door"></i>
                    <span class="d-none d-sm-inline">Home</span>
                </a>
                <span class="gtb-member-pill d-none d-md-inline-flex">
                    <i class="bi bi-patch-check-fill text-danger me-1"></i> Customer Account
                </span>
                <a href="{{ route('shop') }}" class="gtb-banner-cta">
                    <i class="bi bi-cart3"></i>
                    <span>Start Shopping</span>
                </a>
            </div>
        </div>

        {{-- Mobile Scrollable Nav Tabs (< 992px) --}}
        <div class="gtb-mobile-tabs-wrap">
            <div class="gtb-mobile-tabs-scroll">
                <a href="{{ route('account.dashboard') }}" class="gtb-mobile-tab-pill active">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('account.orders') }}" class="gtb-mobile-tab-pill">
                    <i class="bi bi-box-seam"></i> My Orders
                    @if($totalOrders > 0)
                        <span class="badge bg-danger ms-1" style="font-size: 10px;">{{ $totalOrders }}</span>
                    @endif
                </a>
                <a href="{{ route('account.profile') }}" class="gtb-mobile-tab-pill">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a href="{{ route('account.addresses') }}" class="gtb-mobile-tab-pill">
                    <i class="bi bi-geo-alt"></i> Addresses
                </a>
                <a href="{{ route('wishlist.index') }}" class="gtb-mobile-tab-pill">
                    <i class="bi bi-heart"></i> Wishlist
                    @if($wishlistCount > 0)
                        <span class="badge bg-danger ms-1" style="font-size: 10px;">{{ $wishlistCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            {{-- 2. Left Sidebar (Desktop & Tablet) --}}
            <div class="col-lg-3 d-none d-lg-block">
                <div class="gtb-dash-sidebar">
                    {{-- User Profile Card --}}
                    <div class="text-center">
                        <div class="gtb-avatar-ring">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="gtb-avatar-img">
                        </div>
                        <h5 class="gtb-user-name">{{ auth()->user()->name }}</h5>
                        <div class="gtb-user-email">{{ auth()->user()->email }}</div>
                        <span class="gtb-member-pill">
                            <i class="bi bi-shield-check text-danger me-1"></i> Verified Member
                        </span>
                    </div>

                    {{-- Navigation Links --}}
                    <nav class="gtb-dash-nav">
                        {{-- Dashboard (Active) --}}
                        <a href="{{ route('account.dashboard') }}"
                            class="gtb-dash-nav-link {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
                            <div class="nav-left">
                                <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                                <span>Dashboard</span>
                            </div>
                            <i class="bi bi-chevron-right small opacity-75"></i>
                        </a>

                        {{-- My Orders --}}
                        <a href="{{ route('account.orders') }}"
                            class="gtb-dash-nav-link {{ request()->routeIs('account.orders*') ? 'active' : '' }}">
                            <div class="nav-left">
                                <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                                <span>My Orders</span>
                            </div>
                            @if($totalOrders > 0)
                                <span class="badge nav-badge bg-primary">{{ $totalOrders }}</span>
                            @else
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            @endif
                        </a>

                        {{-- Profile --}}
                        <a href="{{ route('account.profile') }}"
                            class="gtb-dash-nav-link {{ request()->routeIs('account.profile') ? 'active' : '' }}">
                            <div class="nav-left">
                                <span class="nav-icon"><i class="bi bi-person"></i></span>
                                <span>Profile</span>
                            </div>
                            <i class="bi bi-chevron-right small opacity-50"></i>
                        </a>

                        {{-- Addresses --}}
                        <a href="{{ route('account.addresses') }}"
                            class="gtb-dash-nav-link {{ request()->routeIs('account.addresses') ? 'active' : '' }}">
                            <div class="nav-left">
                                <span class="nav-icon"><i class="bi bi-geo-alt"></i></span>
                                <span>Addresses</span>
                            </div>
                            <i class="bi bi-chevron-right small opacity-50"></i>
                        </a>

                        {{-- Wishlist --}}
                        <a href="{{ route('wishlist.index') }}"
                            class="gtb-dash-nav-link {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
                            <div class="nav-left">
                                <span class="nav-icon"><i class="bi bi-heart"></i></span>
                                <span>Wishlist</span>
                            </div>
                            @if($wishlistCount > 0)
                                <span class="badge nav-badge bg-danger">{{ $wishlistCount }}</span>
                            @else
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            @endif
                        </a>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-top">
                            @csrf
                            <button type="submit" class="gtb-dash-nav-link nav-logout w-100 text-start border-0 bg-transparent">
                                <div class="nav-left">
                                    <span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>
                                    <span>Logout</span>
                                </div>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- 3. Right Content Area --}}
            <div class="col-lg-9">
                {{-- Three Metric Cards (Matching GTB Logo Colors) --}}
                <div class="row g-3 g-md-4 mb-4">
                    {{-- Metric 1: Total Orders (Deep Navy Blue Gradient) --}}
                    <div class="col-md-4">
                        <div class="gtb-stat-card gtb-stat-orders">
                            <i class="bi bi-box-seam gtb-stat-watermark"></i>
                            <div class="gtb-stat-top">
                                <div class="gtb-stat-icon-wrap">
                                    <i class="bi bi-bag-check-fill"></i>
                                </div>
                                <span class="gtb-stat-tag">All Time</span>
                            </div>
                            <div class="gtb-stat-mid">
                                <div class="gtb-stat-num">{{ $totalOrders }}</div>
                                <div class="gtb-stat-label">Total Orders</div>
                            </div>
                            <div class="gtb-stat-foot">
                                <a href="{{ route('account.orders') }}" class="gtb-stat-link">
                                    <span>View all orders</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Metric 2: Total Spent (Crimson Red Gradient - Logo Accent) --}}
                    <div class="col-md-4">
                        <div class="gtb-stat-card gtb-stat-spent">
                            <i class="bi bi-wallet2 gtb-stat-watermark"></i>
                            <div class="gtb-stat-top">
                                <div class="gtb-stat-icon-wrap">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>
                                <span class="gtb-stat-tag">Paid Orders</span>
                            </div>
                            <div class="gtb-stat-mid">
                                <div class="gtb-stat-num">₹{{ number_format($totalSpent, 0) }}</div>
                                <div class="gtb-stat-label">Total Spent</div>
                            </div>
                            <div class="gtb-stat-foot">
                                <span>Lifetime Purchases</span>
                            </div>
                        </div>
                    </div>

                    {{-- Metric 3: Wishlist Items (Crisp White Card with Navy & Red Accents) --}}
                    <div class="col-md-4">
                        <div class="gtb-stat-card gtb-stat-wishlist">
                            <i class="bi bi-heart gtb-stat-watermark"></i>
                            <div class="gtb-stat-top">
                                <div class="gtb-stat-icon-wrap">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                                <span class="gtb-stat-tag">Saved</span>
                            </div>
                            <div class="gtb-stat-mid">
                                <div class="gtb-stat-num">{{ $wishlistCount }}</div>
                                <div class="gtb-stat-label">Wishlist Items</div>
                            </div>
                            <div class="gtb-stat-foot">
                                <a href="{{ route('wishlist.index') }}" class="gtb-stat-link">
                                    <span>Explore Wishlist</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Recent Orders Panel --}}
                <div class="gtb-orders-panel">
                    <div class="gtb-orders-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="gtb-stat-icon-wrap" style="background:#EAF3F9; color:#0B3A63;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <h3 class="gtb-orders-header-title mb-0">Recent Orders</h3>
                                <p class="gtb-orders-header-sub">Your latest 5 purchases and their live status</p>
                            </div>
                        </div>
                        <a href="{{ route('account.orders') }}" class="gtb-btn-view-all">
                            <span>View All Orders</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    {{-- Order Items List --}}
                    @forelse($recentOrders as $order)
                    <div class="gtb-order-row">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                            {{-- Left: Order Details & Thumbnails --}}
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex align-items-center justify-content-between justify-content-md-start gap-2 mb-1">
                                    <div class="gtb-order-num text-truncate">#{{ $order->order_number }}</div>
                                    <div class="d-md-none">
                                        @php
                                            $status = strtolower($order->status);
                                            $pillClass = match($status) {
                                                'confirmed' => 'gtb-status-confirmed',
                                                'pending'   => 'gtb-status-pending',
                                                'processing'=> 'gtb-status-processing',
                                                'shipped'   => 'gtb-status-shipped',
                                                'delivered' => 'gtb-status-delivered',
                                                'cancelled' => 'gtb-status-cancelled',
                                                default     => 'gtb-status-default'
                                            };
                                            $iconClass = match($status) {
                                                'confirmed' => 'bi-check-circle-fill',
                                                'pending'   => 'bi-hourglass-split',
                                                'processing'=> 'bi-arrow-repeat',
                                                'shipped'   => 'bi-truck',
                                                'delivered' => 'bi-bag-check-fill',
                                                'cancelled' => 'bi-x-circle-fill',
                                                default     => 'bi-info-circle-fill'
                                            };
                                        @endphp
                                        <span class="gtb-status-pill {{ $pillClass }}">
                                            <i class="bi {{ $iconClass }}"></i> {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="gtb-order-meta">
                                    <span>
                                        <i class="bi bi-calendar3 me-1 text-secondary"></i>
                                        {{ $order->created_at->format('d M Y, h:i A') }}
                                    </span>
                                    <span>•</span>
                                    <span>
                                        <i class="bi bi-box-seam me-1 text-secondary"></i>
                                        {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                    </span>
                                </div>

                                {{-- Product Thumbnails preview --}}
                                @if($order->items && $order->items->count())
                                <div class="gtb-order-thumbs">
                                    @foreach($order->items->take(3) as $item)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->product_name ?? 'Product' }}"
                                            class="gtb-order-thumb" title="{{ $item->product_name }}">
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div class="gtb-order-thumb-more" title="{{ $order->items->count() - 3 }} more products">
                                            +{{ $order->items->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                                @endif
                            </div>

                            {{-- Middle/Right: Price & Status (Desktop) --}}
                            <div class="d-none d-md-flex flex-column align-items-end text-end" style="min-width: 140px;">
                                <div class="gtb-order-price">₹{{ number_format($order->total, 2) }}</div>
                                @php
                                    $status = strtolower($order->status);
                                    $pillClass = match($status) {
                                        'confirmed' => 'gtb-status-confirmed',
                                        'pending'   => 'gtb-status-pending',
                                        'processing'=> 'gtb-status-processing',
                                        'shipped'   => 'gtb-status-shipped',
                                        'delivered' => 'gtb-status-delivered',
                                        'cancelled' => 'gtb-status-cancelled',
                                        default     => 'gtb-status-default'
                                    };
                                    $iconClass = match($status) {
                                        'confirmed' => 'bi-check-circle-fill',
                                        'pending'   => 'bi-hourglass-split',
                                        'processing'=> 'bi-arrow-repeat',
                                        'shipped'   => 'bi-truck',
                                        'delivered' => 'bi-bag-check-fill',
                                        'cancelled' => 'bi-x-circle-fill',
                                        default     => 'bi-info-circle-fill'
                                    };
                                @endphp
                                <span class="gtb-status-pill {{ $pillClass }}">
                                    <i class="bi {{ $iconClass }}"></i> {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            {{-- Mobile Bottom Row: Price + View button --}}
                            <div class="d-flex d-md-none align-items-center justify-content-between pt-2 border-top">
                                <div class="gtb-order-price mb-0">₹{{ number_format($order->total, 2) }}</div>
                                <a href="{{ route('account.orders.show', $order) }}" class="gtb-btn-view-order">
                                    <span>View Details</span>
                                    <i class="bi bi-chevron-right small"></i>
                                </a>
                            </div>

                            {{-- Desktop View Button --}}
                            <div class="d-none d-md-block ms-md-2">
                                <a href="{{ route('account.orders.show', $order) }}" class="gtb-btn-view-order" title="View Order Details">
                                    <span>View</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="gtb-empty-orders">
                        <div class="gtb-empty-icon">
                            <i class="bi bi-bag-x"></i>
                        </div>
                        <h4 class="gtb-empty-title">No orders placed yet</h4>
                        <p class="gtb-empty-desc">
                            Explore our premium catalog of disposable crockery, tableware, party supplies, and catering essentials.
                        </p>
                        <a href="{{ route('shop') }}" class="gtb-banner-cta">
                            <i class="bi bi-cart3"></i>
                            <span>Explore Products Now</span>
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- 5. Customer Trust & Assurance Feature Strip --}}
                <div class="gtb-account-trust-strip">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="gtb-trust-item">
                                <div class="gtb-trust-icon gtb-trust-navy">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="gtb-trust-content">
                                    <h6>Certified Quality</h6>
                                    <span>Durable & Food-Grade Supplies</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="gtb-trust-item">
                                <div class="gtb-trust-icon gtb-trust-red">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div class="gtb-trust-content">
                                    <h6>Fast Dispatch</h6>
                                    <span>Secure Delivery Across India</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="gtb-trust-item">
                                <div class="gtb-trust-icon gtb-trust-green">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <div class="gtb-trust-content">
                                    <h6>Dedicated Support</h6>
                                    <span>{{ setting('site_phone', '+91 9310099249') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
