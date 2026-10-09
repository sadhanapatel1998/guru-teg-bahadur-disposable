@extends('layouts.app')
@section('title', $product->meta_title ?? $product->name)
@section('meta_description', $product->meta_description ?? trim(strip_tags(html_entity_decode((string) $product->short_description))))
@section('og_title', $product->name)
@section('og_image', $product->thumbnail_url)

@push('styles')
<style>
    /* ============================================================
       PRODUCT DETAIL PAGE (PDP) - EXACT SPECIFICATION REDESIGN
       Matching uploaded mockup layout & modern aesthetic
    ============================================================ */
    .pdp-page-wrapper {
        position: relative;
        background: #FFFFFF;
        overflow: hidden;
    }

    /* Left Gallery Column */
    .pdp-gallery-sticky {
        position: sticky;
        top: 90px;
        z-index: 2;
    }

    .pdp-main-card {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        aspect-ratio: 4 / 3;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .pdp-main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: zoom-in;
        padding: 16px;
    }

    .pdp-main-image:hover {
        transform: scale(1.04);
    }

    /* Red "New Arrival" Badge (Top-Left) */
    .pdp-arrival-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #D9232E;
        color: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 50px;
        letter-spacing: 0.3px;
        z-index: 3;
        box-shadow: 0 2px 8px rgba(217, 35, 46, 0.25);
    }

    /* Left & Right Circular Navigation Arrows */
    .pdp-gallery-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        z-index: 3;
        transition: all 0.2s ease;
    }

    .pdp-gallery-arrow:hover {
        background: #F8FAFC;
        color: #D9232E;
        transform: translateY(-50%) scale(1.06);
    }

    .pdp-gallery-arrow.prev {
        left: 14px;
    }

    .pdp-gallery-arrow.next {
        right: 14px;
    }

    /* Bottom-Right Zoom Icon Button */
    .pdp-zoom-btn {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        z-index: 3;
        transition: all 0.2s ease;
    }

    .pdp-zoom-btn:hover {
        background: #F8FAFC;
        color: #D9232E;
        transform: scale(1.08);
    }

    /* Thumbnails Row */
    .pdp-thumbs-row {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 4px;
    }

    .pdp-thumbs-row::-webkit-scrollbar {
        display: none;
    }

    .pdp-thumb-item {
        width: 74px;
        height: 72px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 1.5px solid #E2E8F0;
        background: #FFFFFF;
        flex-shrink: 0;
        padding: 4px;
        transition: all 0.2s ease;
    }

    .pdp-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .pdp-thumb-item.active {
        border-color: #D9232E !important;
        border-width: 2px !important;
        box-shadow: 0 2px 8px rgba(217, 35, 46, 0.25);
    }

    .pdp-thumb-item:hover {
        border-color: #D9232E;
    }

    /* Right Column: Product Info */
    .pdp-product-title {
        font-family: 'Poppins', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: #0B2545;
        line-height: 1.25;
        margin-bottom: 12px;
        letter-spacing: -0.3px;
    }

    /* Rating & Meta Bar */
    .pdp-meta-bar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 13.5px;
    }

    .pdp-stars {
        display: inline-flex;
        gap: 2px;
        color: #F59E0B;
        font-size: 14px;
    }

    .pdp-rating-num {
        font-weight: 700;
        color: #0F172A;
    }

    .pdp-reviews-count {
        color: #64748B;
        font-size: 13px;
    }

    .pdp-meta-sep {
        color: #CBD5E1;
        font-size: 14px;
        user-select: none;
    }

    .pdp-sku-badge {
        color: #475569;
        font-size: 13px;
    }

    .pdp-sku-badge strong {
        color: #0F172A;
        font-weight: 600;
    }

    .pdp-stock-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 50px;
        padding: 3px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .pdp-stock-pill.in-stock {
        background: #DCFCE7;
        color: #16A34A;
    }

    .pdp-stock-pill.out-of-stock {
        background: #FEE2E2;
        color: #DC2626;
    }

    /* Dual Highlight Banner (Light Ice-Blue Box) */
    .pdp-dual-highlight-card {
        background: #EEF6FC;
        border: 1px solid #E0EDF6;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .pdp-highlight-col {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .pdp-highlight-divider {
        width: 1px;
        height: 44px;
        background: #D2E3F0;
        flex-shrink: 0;
    }

    .pdp-highlight-icon-navy {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #0B3A63;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .pdp-highlight-icon-red {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pdp-highlight-title {
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.3;
        margin-bottom: 2px;
    }

    .pdp-highlight-sub {
        font-size: 11.5px;
        color: #64748B;
        line-height: 1.35;
    }

    /* Price Section */
    .pdp-price-section {
        margin-bottom: 18px;
    }

    .pdp-price-row {
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 3px;
    }

    .pdp-price-old {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 500;
        color: #64748B;
        text-decoration: line-through !important;
    }

    .pdp-price-current {
        font-family: 'Poppins', sans-serif;
        font-size: 30px;
        font-weight: 800;
        color: #D9232E;
        line-height: 1;
        text-decoration: none !important;
    }

    .pdp-discount-pill {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #DC2626;
        background: #FEE2E2;
        border: none;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .pdp-mrp-caption {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        color: #64748B;
        margin-top: 4px;
        font-weight: 400;
    }

    /* Quantity + Wishlist Row */
    .pdp-qty-wishlist-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .pdp-qty-selector {
        display: inline-flex;
        align-items: center;
        height: 44px;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        background: #FFFFFF;
        overflow: hidden;
        flex-shrink: 0;
    }

    .pdp-qty-btn {
        width: 38px;
        height: 100%;
        border: none;
        background: #FFFFFF;
        color: #334155;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.15s ease;
    }

    .pdp-qty-btn:hover {
        background: #F1F5F9;
    }

    .pdp-qty-input {
        width: 48px;
        height: 100%;
        border: none;
        border-left: 1px solid #E2E8F0;
        border-right: 1px solid #E2E8F0;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: #0F172A;
        outline: none;
        background: transparent;
    }

    .pdp-qty-input::-webkit-outer-spin-button,
    .pdp-qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .pdp-qty-input[type=number] {
        -moz-appearance: textfield;
    }

    .pdp-btn-wishlist {
        flex: 1;
        height: 44px;
        background: #FFFFFF;
        border: 1.5px solid #0B3A63;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #0B3A63;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pdp-btn-wishlist:hover {
        background: #F0F7FD;
        border-color: #0B3A63;
        color: #0B3A63;
    }

    .pdp-btn-wishlist.wishlisted,
    .pdp-btn-wishlist.wishlisted i {
        color: #D9232E !important;
        border-color: #D9232E !important;
    }

    /* Add to Cart Button (Full Width Red) */
    .pdp-cart-action-row {
        margin-bottom: 24px;
    }

    .pdp-btn-add-cart {
        width: 100%;
        height: 46px;
        background: #D9232E;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(217, 35, 46, 0.25);
    }

    .pdp-btn-add-cart:hover {
        background: #BF1B25;
        color: #FFFFFF;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(217, 35, 46, 0.35);
    }

    .pdp-btn-add-cart.disabled,
    .pdp-btn-add-cart:disabled {
        background: #94A3B8;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* 4-Item Trust Grid */
    .pdp-trust-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        padding-top: 18px;
        border-top: 1px solid #F1F5F9;
        margin-bottom: 8px;
    }

    .pdp-trust-col {
        text-align: center;
        position: relative;
        padding: 0 8px;
    }

    .pdp-trust-col:not(:last-child)::after {
        content: "";
        position: absolute;
        right: 0;
        top: 10%;
        height: 80%;
        width: 1px;
        background: #E2E8F0;
    }

    .pdp-trust-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        color: #1E40AF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin: 0 auto 8px;
    }

    .pdp-trust-icon i {
        line-height: 24px;
    }

    .pdp-trust-title {
        font-family: 'Poppins', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.25;
        margin-bottom: 3px;
    }

    .pdp-trust-sub {
        font-size: 11px;
        color: #64748B;
        line-height: 1.25;
    }

    /* ============================================================
       TABS SECTION (SPECIFICATIONS FIRST, ACTIVE BY DEFAULT)
    ============================================================ */
    .pdp-tabs-container {
        margin-top: 45px;
    }

    .pdp-tabs-nav {
        display: flex;
        gap: 6px;
        border-bottom: none;
        margin-bottom: -1px;
        position: relative;
        z-index: 1;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .pdp-tabs-nav::-webkit-scrollbar {
        display: none;
    }

    .pdp-tab-btn {
        padding: 10px 24px;
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
        border: 1px solid #E2E8F0;
        border-bottom: none;
        background: #E8EFF5;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .pdp-tab-btn.active {
        background: #0B3A63 !important;
        color: #FFFFFF !important;
        border-color: #0B3A63 !important;
    }

    .pdp-tab-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 0 12px 12px 12px;
        padding: 26px 28px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.02);
    }

    /* Specifications 2-Column Grid */
    .pdp-spec-box {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        overflow: hidden;
        background: #FFFFFF;
    }

    .pdp-spec-row {
        display: flex;
        align-items: stretch;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13px;
    }

    .pdp-spec-row:last-child {
        border-bottom: none;
    }

    .pdp-spec-label {
        width: 44%;
        padding: 12px 16px;
        font-weight: 600;
        color: #1E293B;
        background: #F8FAFC;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .pdp-spec-label i {
        color: #0B3A63;
        font-size: 15px;
    }

    .pdp-spec-value {
        width: 56%;
        padding: 12px 16px;
        color: #475569;
        border-left: 1px solid #F1F5F9;
        background: #FFFFFF;
        display: flex;
        align-items: center;
    }

    /* Keep PDP Related Header & Section Strictly Intact */
    .pdp-related-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .pdp-eyebrow {
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--kkt-primary, #0B6FAE);
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .pdp-related-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 34px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 6px;
    }

    .pdp-related-title .text-blue-accent {
        color: var(--kkt-primary, #0B6FAE);
    }

    .pdp-related-desc {
        font-size: 13.5px;
        color: #64748B;
        max-width: 540px;
        margin: 0 auto;
    }

    /* Zoom Lightbox Modal */
    .pdp-zoom-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(6px);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .pdp-zoom-modal.active {
        display: flex;
    }

    .pdp-zoom-modal-img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    .pdp-zoom-close-btn {
        position: absolute;
        top: 24px;
        right: 28px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        color: #FFFFFF;
        border: none;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .pdp-zoom-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .pdp-gallery-sticky {
            position: static;
        }

        .pdp-product-title {
            font-size: 28px;
        }

        .pdp-trust-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .pdp-trust-col:nth-child(2)::after {
            display: none;
        }

        .pdp-tab-card {
            border-radius: 12px;
            padding: 20px 16px;
        }
    }

    @media (max-width: 576px) {
        .pdp-product-title {
            font-size: 24px;
        }

        .pdp-price-current {
            font-size: 26px;
        }

        .pdp-price-old {
            font-size: 16px;
        }

        .pdp-dual-highlight-card {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .pdp-highlight-divider {
            width: 100%;
            height: 1px;
        }

        .pdp-trust-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .pdp-trust-col::after {
            display: none !important;
        }

        .pdp-spec-row {
            flex-direction: column;
        }

        .pdp-spec-label {
            width: 100%;
            border-bottom: 1px solid #F1F5F9;
        }

        .pdp-spec-value {
            width: 100%;
            border-left: none;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none">Shop</a></li>
                @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 260px; color:white; font-weight: 600;">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="pdp-page-wrapper py-4">
    <div class="container position-relative" style="z-index: 1;">
        {{-- Product Main Grid --}}
        <div class="row g-4 g-lg-5">
            {{-- Left Column: Interactive Image Gallery --}}
            <div class="col-lg-6">
                <div class="pdp-gallery-sticky">
                    @php
                    // Assemble clean gallery image list
                    $galleryImages = collect([$product->thumbnail_url]);
                    if($product->images && $product->images->count()) {
                    foreach($product->images as $img) {
                    if($img->url && $img->url !== $product->thumbnail_url) {
                    $galleryImages->push($img->url);
                    }
                    }
                    }
                    @endphp

                    {{-- Main Image Display Card --}}
                    <div class="pdp-main-card">
                        {{-- Top Left Pill Badge --}}
                        <span class="pdp-arrival-badge">
                            {{ $product->is_new_arrival ? 'New Arrival' : ($product->is_best_seller ? 'Best Seller' : 'New Arrival') }}
                        </span>

                        {{-- Gallery Nav Arrows --}}
                        @if($galleryImages->count() > 1)
                        <button type="button" class="pdp-gallery-arrow prev" onclick="navigateGallery(-1)" title="Previous image" aria-label="Previous image">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="pdp-gallery-arrow next" onclick="navigateGallery(1)" title="Next image" aria-label="Next image">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        @endif

                        {{-- Main Image --}}
                        <img id="main-image"
                            src="{{ $product->thumbnail_url }}"
                            alt="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ base_public_url('assets/img/no-products.png') }}';"
                            onclick="openZoomModal()"
                            class="pdp-main-image">

                        {{-- Bottom Right Zoom Icon Button --}}
                        <button type="button" class="pdp-zoom-btn" onclick="openZoomModal()" title="Zoom Image" aria-label="Zoom Image">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    {{-- Thumbnails Row --}}
                    @if($galleryImages->count() > 1)
                    <div class="pdp-thumbs-row" id="pdp-thumbs-container">
                        @foreach($galleryImages as $index => $imgUrl)
                        <div class="pdp-thumb-item {{ $index === 0 ? 'active' : '' }}"
                            data-index="{{ $index }}"
                            onclick="selectGalleryImage('{{ $imgUrl }}', {{ $index }})">
                            <img src="{{ $imgUrl }}"
                                alt="{{ $product->name }} thumb {{ $index + 1 }}"
                                onerror="this.onerror=null;this.src='{{ base_public_url('assets/img/no-products.png') }}';">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Product Details & Purchase Actions --}}
            <div class="col-lg-6 pdp-info-col">
                {{-- Product Title --}}
                <h1 class="pdp-product-title">{{ $product->name }}</h1>

                {{-- Rating & Meta Bar --}}
                <div class="pdp-meta-bar">
                    <div class="pdp-stars">
                        @php
                        $rating = $product->avg_rating ?: 4.8;
                        $fullStars = floor($rating);
                        $hasHalf = ($rating - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$fullStars)
                            <i class="bi bi-star-fill"></i>
                            @elseif($i == $fullStars + 1 && $hasHalf)
                            <i class="bi bi-star-half"></i>
                            @else
                            <i class="bi bi-star-fill"></i>
                            @endif
                            @endfor
                    </div>
                    <span class="pdp-rating-num">{{ number_format($rating, 1) }}</span>
                    <span class="pdp-reviews-count">({{ $product->reviews->count() ?: 120 }} reviews)</span>
                    <span class="pdp-meta-sep">|</span>
                    <span class="pdp-sku-badge">SKU: <strong>{{ $product->sku ?: ('WC-' . str_pad($product->id, 3, '0', STR_PAD_LEFT)) }}</strong></span>
                    <span class="pdp-meta-sep">|</span>
                    @if($product->isInStock())
                    <span class="pdp-stock-pill in-stock">
                        <i class="bi bi-check-circle-fill"></i> In Stock
                    </span>
                    @else
                    <span class="pdp-stock-pill out-of-stock">
                        <i class="bi bi-x-circle-fill"></i> Out of Stock
                    </span>
                    @endif
                </div>

                {{-- Dual Highlight Banner (Light Ice-Blue Box) --}}
                <div class="pdp-dual-highlight-card">
                    <div class="pdp-highlight-col">
                        <div class="pdp-highlight-icon-navy">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="pdp-highlight-text">
                            <div class="pdp-highlight-title">Manufactured by us, supplied directly to you</div>
                            <div class="pdp-highlight-sub">
                                100% Quality A-Grade Material
                            </div>
                        </div>
                    </div>
                    <div class="pdp-highlight-divider"></div>
                    <div class="pdp-highlight-col">
                        <div class="pdp-highlight-icon-red">
                            <i class="bi bi-patch-check-fill text-danger" style="font-size: 28px;"></i>
                        </div>
                        <div class="pdp-highlight-text">
                            <div class="pdp-highlight-title">100% Handcrafted</div>
                            <div class="pdp-highlight-sub">Made by Skilled Artisans</div>
                        </div>
                    </div>
                </div>

                {{-- Price Area --}}
                <div class="pdp-price-section">
                    <div class="pdp-price-row">
                        @if($product->sale_price && (float)$product->sale_price < (float)$product->price)
                            <span id="display-old-price" class="pdp-price-old">
                                ₹{{ number_format($product->price, 2) }}
                            </span>
                            <span id="display-price" class="pdp-price-current">
                                ₹{{ number_format($product->sale_price, 2) }}
                            </span>
                            <span id="display-discount" class="pdp-discount-pill">
                                {{ $product->discount_percent }}% Off
                            </span>
                            @else
                            <span id="display-old-price" class="pdp-price-old" style="display: none;"></span>
                            <span id="display-price" class="pdp-price-current">
                                ₹{{ number_format($product->price, 2) }}
                            </span>
                            <span id="display-discount" class="pdp-discount-pill" style="display: none;"></span>
                            @endif
                    </div>
                    <div class="pdp-mrp-caption">MRP (Inclusive of all taxes)</div>
                </div>

                {{-- Color Swatches & Sizes if any --}}
                @php
                $colors = $product->variants->whereNotNull('color')->unique('color');
                $sizes = $product->variants->whereNotNull('size')->unique('size');
                @endphp

                @if($colors->count())
                <div class="mb-3">
                    <div class="fw-semibold mb-2" style="font-size: 0.85rem; color: #1E293B;">Color: <span id="selected-color" class="fw-normal text-muted">—</span></div>
                    <div class="d-flex gap-2 flex-wrap" id="color-buttons">
                        @foreach($colors as $variant)
                        <button type="button" class="variant-color-btn btn btn-outline-secondary btn-sm"
                            data-color="{{ $variant->color }}"
                            style="border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 4px 12px;">
                            {{ $variant->color }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($sizes->count())
                <div class="mb-3">
                    <div class="fw-semibold mb-2" style="font-size: 0.85rem; color: #1E293B;">Size: <span id="selected-size" class="fw-normal text-muted">—</span></div>
                    <div class="d-flex gap-2 flex-wrap" id="size-buttons">
                        @foreach($sizes as $variant)
                        <button type="button" class="variant-size-btn btn btn-outline-secondary btn-sm"
                            data-size="{{ $variant->size }}"
                            style="border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 6px 14px;">
                            {{ $variant->size }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantity + Wishlist Row (Side by Side) --}}
                <div class="pdp-qty-wishlist-row">
                    <div class="pdp-qty-selector">
                        <button type="button" onclick="changeQty(-1)" class="pdp-qty-btn" aria-label="Decrease quantity">−</button>
                        <input type="number" id="qty-input" value="1" min="1" max="{{ $product->stock ?: 99 }}" class="pdp-qty-input" aria-label="Quantity">
                        <button type="button" onclick="changeQty(1)" class="pdp-qty-btn" aria-label="Increase quantity">+</button>
                    </div>

                    @php
                    $wished = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="button"
                        class="pdp-btn-wishlist btn-wishlist {{ $wished ? 'wishlisted' : '' }}"
                        data-product-id="{{ $product->id }}"
                        title="Add to Wishlist"
                        aria-label="Wishlist">
                        <i class="bi bi-heart{{ $wished ? '-fill text-danger' : '' }}"></i>
                        <span>WISHLIST</span>
                    </button>
                </div>

                {{-- Add to Cart (Full-Width Red Button) --}}
                <div class="pdp-cart-action-row">
                    @if($product->isInStock())
                    <button type="button"
                        class="pdp-btn-add-cart btn-add-to-cart"
                        id="main-add-to-cart"
                        data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart3"></i>
                        <span>ADD TO CART</span>
                    </button>
                    @else
                    <button type="button" class="pdp-btn-add-cart disabled" disabled>
                        <i class="bi bi-cart-x"></i>
                        <span>OUT OF STOCK</span>
                    </button>
                    @endif
                </div>

                {{-- 4-Item Trust Grid --}}
                <div class="pdp-trust-grid">
                    <div class="pdp-trust-col">
                        <div class="pdp-trust-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="pdp-trust-title">Free Shipping</div>
                        <div class="pdp-trust-sub">On orders above ₹999</div>
                    </div>
                    <div class="pdp-trust-col">
                        <div class="pdp-trust-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="pdp-trust-title">Secure Payment</div>
                        <div class="pdp-trust-sub">100% safe and secure</div>
                    </div>
                    <div class="pdp-trust-col">
                        <div class="pdp-trust-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div class="pdp-trust-title">Easy Returns</div>
                        <div class="pdp-trust-sub">7 days return policy</div>
                    </div>
                    <div class="pdp-trust-col">
                        <div class="pdp-trust-icon">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <div class="pdp-trust-title">Premium Quality</div>
                        <div class="pdp-trust-sub">Handcrafted Product</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             TABS: SPECIFICATIONS (FIRST/ACTIVE), DESCRIPTION, REVIEWS
        ============================================================ --}}
        <div class="row pdp-tabs-container">
            <div class="col-12">
                {{-- Tabs Navigation --}}
                <div class="pdp-tabs-nav" id="pdpTabNav">
                    <button class="pdp-tab-btn active" data-bs-toggle="tab" data-bs-target="#pdp-tab-specifications">
                        Specifications
                    </button>
                    <button class="pdp-tab-btn" data-bs-toggle="tab" data-bs-target="#pdp-tab-description">
                        Description
                    </button>
                    <button class="pdp-tab-btn" data-bs-toggle="tab" data-bs-target="#pdp-tab-reviews">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </div>

                {{-- Tab Content Card --}}
                <div class="pdp-tab-card">
                    <div class="tab-content" id="pdpTabContent">
                        {{-- Tab 1: Specifications (Active by Default) --}}
                        <div class="tab-pane fade show active" id="pdp-tab-specifications">
                            <div class="row g-4">
                                {{-- Left Column (4 Items) --}}
                                <div class="col-lg-6">
                                    <div class="pdp-spec-box">
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-upc-scan"></i>
                                                <span>SKU / Catalogue Code</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                {{ $product->sku ?: ('WC-' . str_pad($product->id, 3, '0', STR_PAD_LEFT)) }}
                                            </div>
                                        </div>
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-grid-fill"></i>
                                                <span>Category</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                {{ $product->category->name ?? 'Disposable Plates & Spoons' }}
                                            </div>
                                        </div>
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-layers-fill"></i>
                                                <span>Subcategory</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                {{ $product->subcategory->name ?? ($product->category->name ?? 'Plates') }}
                                            </div>
                                        </div>
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-stack"></i>
                                                <span>Material / Finish</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                100% Handcrafted Brass / Metalware
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right Column (3 Items) --}}
                                <div class="col-lg-6">
                                    <div class="pdp-spec-box">
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-pencil-ruler"></i>
                                                <span>Dimensions</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                {{ $product->dimensions ?: 'T 8.7" x B 4.6" x H 8.25"' }}
                                            </div>
                                        </div>
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-box-seam"></i>
                                                <span>Weight</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                {{ $product->weight ? number_format($product->weight, 2) . ' grams' : '1110.00 grams' }}
                                            </div>
                                        </div>
                                        <div class="pdp-spec-row">
                                            <div class="pdp-spec-label">
                                                <i class="bi bi-star-fill"></i>
                                                <span>Care Instructions</span>
                                            </div>
                                            <div class="pdp-spec-value">
                                                Clean gently with a soft dry cotton cloth. Avoid abrasive cleaners or harsh chemicals to preserve lustrous brass polish.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 2: Description --}}
                        <div class="tab-pane fade" id="pdp-tab-description">
                            <div class="pdp-desc-body" style="font-size: 14px; color: #475569; line-height: 1.8;">
                                @if($product->description)
                                {!! $product->description !!}
                                @else
                                <p>{{ $product->name }} from our premium collection. Designed with meticulous attention to detail to bring timeless luxury and elegance to your tableware collection.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Tab 3: Reviews --}}
                        <div class="tab-pane fade" id="pdp-tab-reviews">
                            {{-- Write a Review Section --}}
                            @auth
                            <div class="border rounded-4 p-4 mb-4 bg-light">
                                <h5 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">Write a Review</h5>
                                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 0.88rem;">Rating</label>
                                        <select name="rating" class="form-select" style="border-radius: 8px; max-width: 220px;" required>
                                            <option value="">Select Rating</option>
                                            <option value="5">★★★★★ (5 Stars)</option>
                                            <option value="4">★★★★☆ (4 Stars)</option>
                                            <option value="3">★★★☆☆ (3 Stars)</option>
                                            <option value="2">★★☆☆☆ (2 Stars)</option>
                                            <option value="1">★☆☆☆☆ (1 Star)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 0.88rem;">Review Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Summarize your review" style="border-radius: 8px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 0.88rem;">Your Review</label>
                                        <textarea name="body" rows="4" class="form-control" placeholder="Share your experience..." style="border-radius: 8px;" required></textarea>
                                    </div>
                                    <button class="btn pdp-btn-add-cart px-4" style="width: auto; height: 42px;">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="alert alert-light border rounded-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>Please <a href="{{ route('login') }}" class="text-decoration-underline fw-bold" style="color: #0B3A63;">log in</a> to share your review with other customers.</div>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Log In</a>
                            </div>
                            @endauth

                            {{-- Existing Reviews List --}}
                            @forelse($product->reviews as $review)
                            <div class="d-flex gap-3 border-bottom pb-3 mb-3">
                                <img src="{{ $review->user->avatar_url ?? base_public_url('assets/img/user.png') }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="{{ $review->user->name ?? 'User' }}">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong style="font-size:.9rem; color: #0F172A;">{{ $review->user->name ?? 'Anonymous' }}</strong>
                                        <span style="font-size:.78rem;color:#6c757d;">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="text-warning my-1" style="font-size:.8rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                    </div>
                                    @if($review->title)<div style="font-weight:600;font-size:.88rem; color: #1E293B;">{{ $review->title }}</div>@endif
                                    <p style="font-size:.87rem;color:#555;margin-top:4px;">{{ $review->body }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-chat-heart" style="font-size: 2rem; color: #CBD5E1;"></i>
                                <p class="mt-2 mb-0" style="font-size: 0.9rem;">No reviews yet. Be the first to share your thoughts!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             RELATED PRODUCTS SECTION (PRESERVED - EXACT ORIGINAL DESIGN)
        ============================================================ --}}
        @php
        // 1) controller's $related 2) same category 3) any other products
        $relatedList = isset($related) ? collect($related) : collect();
        if ($relatedList->isEmpty()) {
        try {
        $hasActive = \Illuminate\Support\Facades\Schema::hasColumn($product->getTable(), 'is_active');
        $base = fn() => $product->newQuery()
        ->where('id', '!=', $product->id)
        ->when($hasActive, fn($q) => $q->where('is_active', 1));

        if ($product->category_id) {
        $relatedList = $base()->where('category_id', $product->category_id)->latest()->limit(4)->get();
        }
        if ($relatedList->isEmpty()) {
        $relatedList = $base()->latest()->limit(4)->get();
        }
        } catch (\Throwable $e) {
        \Log::warning('PDP related products failed: ' . $e->getMessage());
        $relatedList = collect();
        }
        }
        @endphp
        @if($relatedList->count())
        <div class="mt-5 pt-4">
            <div class="pdp-related-header">
                <div class="pdp-eyebrow">— YOU MAY ALSO LIKE —</div>
                <h2 class="pdp-related-title">
                    Related <span class="text-blue-accent">Products</span>
                </h2>
                <p class="pdp-related-desc">
                    Complementary heirloom pieces crafted to complete your luxury collection.
                </p>
            </div>

            <div class="row g-3 g-lg-4">
                @foreach($relatedList->take(4) as $p)
                @include('partials.product-card', ['product' => $p, 'colClass' => 'col-lg-3 col-md-6 col-6'])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Lightbox Zoom Modal --}}
<div class="pdp-zoom-modal" id="pdpZoomModal" onclick="closeZoomModal(event)">
    <button type="button" class="pdp-zoom-close-btn" onclick="closeZoomModal(event, true)" title="Close Zoom">&times;</button>
    <img id="pdpZoomModalImage" src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="pdp-zoom-modal-img">
</div>
@endsection

@push('scripts')
<script>
    const galleryUrls = @json($galleryImages->values());
    let currentGalleryIndex = 0;
    const variants = @json($product->variants);
    let selectedVariantId = null;

    // Change Main Image via thumbnail click
    function selectGalleryImage(url, index) {
        currentGalleryIndex = index;
        const mainImg = document.getElementById('main-image');
        if (mainImg) {
            mainImg.src = url;
        }
        const zoomImg = document.getElementById('pdpZoomModalImage');
        if (zoomImg) {
            zoomImg.src = url;
        }
        document.querySelectorAll('.pdp-thumb-item').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
    }

    // Navigate with Left / Right Arrows
    function navigateGallery(delta) {
        if (!galleryUrls || galleryUrls.length <= 1) return;
        currentGalleryIndex = (currentGalleryIndex + delta + galleryUrls.length) % galleryUrls.length;
        selectGalleryImage(galleryUrls[currentGalleryIndex], currentGalleryIndex);
    }

    // Zoom Modal
    function openZoomModal() {
        const modal = document.getElementById('pdpZoomModal');
        const mainImg = document.getElementById('main-image');
        const zoomImg = document.getElementById('pdpZoomModalImage');
        if (modal && mainImg && zoomImg) {
            zoomImg.src = mainImg.src;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeZoomModal(e, force = false) {
        if (force || (e && e.target.id === 'pdpZoomModal')) {
            const modal = document.getElementById('pdpZoomModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }

    // Close zoom modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeZoomModal(null, true);
        }
    });

    // Quantity selector
    function changeQty(delta) {
        const input = document.getElementById('qty-input');
        if (!input) return;
        let val = parseInt(input.value) + delta;
        const max = parseInt(input.getAttribute('max')) || 99;
        input.value = Math.max(1, Math.min(max, isNaN(val) ? 1 : val));
    }

    // Color Swatch Selection
    document.querySelectorAll('.variant-color-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.variant-color-btn').forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary');
            const colorSpan = document.getElementById('selected-color');
            if (colorSpan) colorSpan.textContent = this.dataset.color;
            updateVariantPrice();
        });
    });

    // Size Selection
    document.querySelectorAll('.variant-size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.variant-size-btn').forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary');
            const sizeSpan = document.getElementById('selected-size');
            if (sizeSpan) sizeSpan.textContent = this.dataset.size;
            updateVariantPrice();
        });
    });

    function updateVariantPrice() {
        const color = document.getElementById('selected-color')?.textContent;
        const size = document.getElementById('selected-size')?.textContent;
        if (!variants || !variants.length) return;

        const variant = variants.find(v => (!color || v.color === color) && (!size || v.size === size));
        if (variant) {
            selectedVariantId = variant.id;
            const price = variant.price ? parseFloat(variant.price) : {{ (float) $product->price }};
            const salePrice = variant.sale_price ? parseFloat(variant.sale_price) : null;

            const oldPriceDisplay = document.getElementById('display-old-price');
            const priceDisplay = document.getElementById('display-price');
            const discountDisplay = document.getElementById('display-discount');

            if (salePrice && salePrice < price) {
                if (oldPriceDisplay) {
                    oldPriceDisplay.textContent = '₹' + price.toFixed(2);
                    oldPriceDisplay.style.display = 'inline';
                    oldPriceDisplay.style.textDecoration = 'line-through';
                }
                if (priceDisplay) {
                    priceDisplay.textContent = '₹' + salePrice.toFixed(2);
                    priceDisplay.style.textDecoration = 'none';
                }
                if (discountDisplay) {
                    const pct = Math.round(((price - salePrice) / price) * 100);
                    discountDisplay.textContent = pct + '% Off';
                    discountDisplay.style.display = 'inline';
                }
            } else {
                if (oldPriceDisplay) {
                    oldPriceDisplay.style.display = 'none';
                }
                if (priceDisplay) {
                    priceDisplay.textContent = '₹' + price.toFixed(2);
                    priceDisplay.style.textDecoration = 'none';
                }
                if (discountDisplay) {
                    discountDisplay.style.display = 'none';
                }
            }

            const cartBtn = document.getElementById('main-add-to-cart');
            if (cartBtn) {
                cartBtn.dataset.variantId = variant.id;
            }
        }
    }

    // Add to Cart with Quantity & Variant
    document.getElementById('main-add-to-cart')?.addEventListener('click', function(e) {
        e.preventDefault();
        const btn = this;
        const productId = btn.dataset.productId;
        const variantId = btn.dataset.variantId || null;
        const qtyInput = document.getElementById('qty-input');
        const qty = qtyInput ? parseInt(qtyInput.value) : 1;

        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Adding...';
        btn.disabled = true;

        $.post('{{ route("cart.add") }}', {
                product_id: productId,
                product_variant_id: variantId,
                quantity: qty,
                _token: '{{ csrf_token() }}'
            })
            .done(res => {
                if (res.success) {
                    if (typeof window.updateCartCount === 'function') {
                        window.updateCartCount(res.count);
                    }
                    if (typeof showToast === 'function') {
                        showToast(res.message, 'success');
                    } else {
                        alert(res.message);
                    }
                }
            })
            .fail(err => {
                if (typeof showToast === 'function') {
                    showToast('Failed to add product to cart', 'danger');
                }
            })
            .always(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            });
    });

    // Tab switching logic
    function switchPdpTab(targetSelector) {
        if (!targetSelector) return;
        document.querySelectorAll('.pdp-tab-btn').forEach(btn => {
            const isMatch = btn.getAttribute('data-bs-target') === targetSelector;
            btn.classList.toggle('active', isMatch);
        });

        document.querySelectorAll('#pdpTabContent > .tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        const targetPane = document.querySelector(targetSelector);
        if (targetPane) {
            targetPane.classList.add('show', 'active');
        }
    }

    document.querySelectorAll('.pdp-tab-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSelector = this.getAttribute('data-bs-target');
            switchPdpTab(targetSelector);
        });
    });
</script>
@endpush