@extends('layouts.app')
@section('title', $product->meta_title ?? $product->name)
@section('meta_description', $product->meta_description ?? trim(strip_tags(html_entity_decode((string) $product->short_description))))
@section('og_title', $product->name)
@section('og_image', $product->thumbnail_url)

@push('styles')
<style>
    /* ============================================================
       FINESSE LUXURY PRODUCT DETAIL PAGE STYLING
    ============================================================ */
    .pdp-page-wrapper {
        position: relative;
        background: #EEF9FD;
        overflow: hidden;
    }

    /* Subtle luxury watermark leaf line-art flourishes */
    .pdp-watermark-art {
        position: absolute;
        pointer-events: none;
        z-index: 0;
        opacity: 0.055;
    }
    .pdp-watermark-left {
        top: 20px;
        left: -40px;
        width: 320px;
        height: 320px;
    }
    .pdp-watermark-right {
        top: 30px;
        right: -40px;
        width: 360px;
        height: 360px;
    }

    /* Gallery Card */
    .pdp-gallery-sticky {
        position: sticky;
        top: 90px;
        z-index: 2;
    }
    .pdp-main-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #EEF1F4;
        background: #FFFFFF;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-top: 30px;
    }
    .pdp-main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: zoom-in;
    }
    .pdp-main-image:hover {
        transform: scale(1.05);
    }

    /* Floating Gallery Overlays */
    .pdp-arrival-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: #0F172A;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 50px;
        letter-spacing: 0.3px;
        z-index: 3;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25);
    }
    .pdp-zoom-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid #E2E8F0;
        color: #1E293B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        z-index: 3;
        transition: all 0.2s ease;
    }
    .pdp-zoom-btn:hover {
        background: #FFFFFF;
        color: var(--kkt-primary, #0B6FAE);
        transform: scale(1.06);
    }
    .pdp-gallery-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid #E2E8F0;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        z-index: 3;
        transition: all 0.2s ease;
    }
    .pdp-gallery-arrow:hover {
        background: #FFFFFF;
        color: var(--kkt-primary, #0B6FAE);
        box-shadow: 0 5px 14px rgba(11, 111, 174, 0.2);
    }
    .pdp-gallery-arrow.prev { left: 12px; }
    .pdp-gallery-arrow.next { right: 12px; }

    .pdp-click-zoom-pill {
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        color: #FFFFFF;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        padding: 5px 16px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        z-index: 3;
        transition: all 0.2s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }
    .pdp-click-zoom-pill:hover {
        background: rgba(11, 111, 174, 0.95);
        transform: translateX(-50%) translateY(-1px);
    }

    /* Thumbnails */
    .pdp-thumbs-row {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 2px;
    }
    .pdp-thumbs-row::-webkit-scrollbar {
        display: none;
    }
    .pdp-thumb-item {
        width: 68px;
        height: 66px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #E8EAED;
        background: #FFFFFF;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .pdp-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pdp-thumb-item.active {
        border-color: var(--kkt-primary, #0B6FAE) !important;
        box-shadow: 0 2px 8px rgba(11, 111, 174, 0.25);
    }
    .pdp-thumb-item:hover {
        border-color: var(--kkt-primary, #0B6FAE);
    }

    /* Product Info Area */
    .pdp-top-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 4px;
    }
    .pdp-category-dash {
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2.5px;
        color: #64748B;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: block;
    }
    .pdp-product-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 30px;
        font-weight: 400;
        color: #2A6A94;
        text-transform: uppercase;
        line-height: 1.2;
        margin-bottom: 14px;
        letter-spacing: 1px;
    }

    /* Top Right Luxury Brand Tagline */
    .pdp-luxury-tagline {
        text-align: right;
        flex-shrink: 0;
    }
    .pdp-tagline-text {
        font-family: 'Playfair Display', Georgia, serif;
        line-height: 1.15;
    }
    .pdp-tagline-text .t-sub {
        font-size: 16px;
        color: #64748B;
        font-weight: 400;
        display: block;
    }
    .pdp-tagline-text .t-accent {
        font-size: 18px;
        color: var(--kkt-primary, #0B6FAE);
        font-weight: 700;
        display: block;
    }
    .pdp-tagline-underline {
        width: 34px;
        height: 3px;
        background: var(--kkt-primary, #0B6FAE);
        border-radius: 2px;
        margin-left: auto;
        margin-top: 6px;
    }

    /* Key Highlights Callout Box */
    .pdp-callout-box {
        background: #C2F0FF;
        border: 1px solid #D3E9F6;
        border-radius: 10px;
        padding: 12px 18px;
        margin-bottom: 18px;
    }
    .pdp-callout-box ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .pdp-callout-box li {
        position: relative;
        margin: 0;
        padding: 0 0 0 14px;
        font-size: 13.5px;
        line-height: 1.55;
        color: #1E293B;
        font-weight: 500;
    }
    .pdp-callout-box li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0.62em;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #000000;
    }
    .pdp-callout-box li .callout-lead {
        display: block;
        margin: 0;
        font-weight: 500;
        color: #0F172A;
    }
    .pdp-callout-box li .callout-lead strong,
    .pdp-callout-box li .callout-lead b {
        font-weight: 600;
    }
    .pdp-callout-box li .callout-sub {
        display: block;
        margin: 0;
        padding: 0;
        color: #1E293B;
        font-weight: 400;
        font-size: 13.5px;
        line-height: 1.55;
    }

    /* Price area (matches reference: light weight, both prices same look, small "% off") */
    .pdp-price-row {
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 2px;
    }
    .pdp-price-current {
        font-family: 'Poppins', sans-serif;
        font-size: 19px;
        font-weight: 600;
        color: #111111;
        letter-spacing: 0;
        text-decoration: none !important;
    }
    .pdp-price-old {
        font-family: 'Poppins', sans-serif;
        font-size: 19px;
        font-weight: 500;
        color: #888888;
        letter-spacing: 0;
        text-decoration: line-through !important;
        text-decoration-thickness: 1.5px;
    }
    .pdp-discount-pill {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 400;
        color: #555555;
        background: transparent;
        border: none;
        padding: 0;
        border-radius: 0;
    }
    .pdp-mrp-caption {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        color: #444444;
        margin-bottom: 16px;
        font-weight: 400;
    }

    /* Short Description */
    .pdp-short-description {
        font-size: 13.5px;
        color: #64748B;
        line-height: 1.65;
        margin-bottom: 18px;
    }

    /* Color Swatch */
    .pdp-color-section {
        margin-bottom: 20px;
    }
    .pdp-color-label {
        font-size: 13px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .pdp-color-label span {
        color: #64748B;
        font-weight: 500;
    }
    .pdp-color-swatch {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        position: relative;
        border: 2px solid #FFFFFF;
        box-shadow: 0 0 0 2px #0F172A;
        transition: transform 0.2s ease;
    }
    .pdp-color-swatch:hover {
        transform: scale(1.08);
    }

    /* Action Buttons (matches reference: Customisation small blue, Add to Cart blue full, Live Demo grey full) */
    .pdp-action-buttons {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
    .pdp-stacked-actions {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        margin-bottom: 22px;
    }
    .pdp-btn-ref {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        font-size: 13px !important;
        font-weight: 500 !important;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        text-decoration: none !important;
        color: #FFFFFF !important;
        border: none !important;
        border-radius: 5px !important;
        cursor: pointer;
        white-space: nowrap;
        box-shadow: none !important;
        transition: background-color 0.2s ease, opacity 0.2s ease;
    }
    .pdp-btn-ref.pdp-btn-blue {
        background: var(--kkt-primary, #0B6FAE) !important;
    }
    .pdp-btn-ref.pdp-btn-blue:hover {
        background: #085485 !important;
    }
    .pdp-btn-ref.pdp-btn-grey {
        background: #5F5F5F !important;
    }
    .pdp-btn-ref.pdp-btn-grey:hover {
        background: #454545 !important;
    }
    .pdp-btn-ref.pdp-btn-small {
        align-self: flex-start;
        height: 36px;
        padding: 0 22px;
    }
    .pdp-btn-ref.pdp-btn-wide {
        width: 100%;
        height: 38px;
    }
    .pdp-btn-ref.disabled,
    .pdp-btn-ref:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .pdp-qty-wishlist-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }
    .pdp-qty-selector {
        display: inline-flex;
        align-items: center;
        height: 44px;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        background: #FFFFFF;
        overflow: hidden;
        flex-shrink: 0;
    }
    .pdp-qty-btn {
        width: 36px;
        height: 100%;
        border: none;
        background: #F8FAFC;
        color: #475569;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
    }
    .pdp-qty-btn:hover {
        background: #E2E8F0;
    }
    .pdp-qty-input {
        width: 44px;
        height: 100%;
        border: none;
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

    /* Submit review button (kept for review form) */
    .pdp-btn-cart {
        height: 44px;
        padding: 0 24px;
        border-radius: 10px !important;
        background: var(--kkt-primary, #0B6FAE) !important;
        color: #FFFFFF !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        border: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        cursor: pointer;
        transition: all 0.25s ease !important;
        box-shadow: 0 4px 14px rgba(11, 111, 174, 0.25) !important;
        white-space: nowrap;
    }
    .pdp-btn-cart:hover {
        background: #085485 !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(11, 111, 174, 0.35) !important;
    }

    .pdp-btn-wishlist {
        height: 44px;
        padding: 0 18px;
        border-radius: 10px !important;
        background: #FFFFFF !important;
        border: 1px solid #CBD5E1 !important;
        color: #334155 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        cursor: pointer;
        transition: all 0.2s ease !important;
        white-space: nowrap;
    }
    .pdp-btn-wishlist:hover {
        background: #F8FAFC !important;
        border-color: #94A3B8 !important;
        color: #0F172A !important;
    }
    .pdp-btn-wishlist.wishlisted,
    .pdp-btn-wishlist:hover i.bi-heart {
        color: #EF4444 !important;
    }

    /* 3-Column Trust Highlights */
    .pdp-info-card {
        background: #FFFFFF;
        border: 1px solid #EEF1F4;
        border-radius: 14px;
        padding: 20px 22px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    }
    .pdp-trust-bar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        padding: 0;
        border: none;
        margin-bottom: 20px;
    }
    .pdp-trust-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pdp-trust-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #EDF6FB;
        color: var(--kkt-primary, #0B6FAE);
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .pdp-trust-title {
        font-size: 12.5px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.2;
    }
    .pdp-trust-sub {
        font-size: 11px;
        color: #64748B;
        margin-top: 2px;
    }

    /* Meta Info & Highlights Card */
    .pdp-meta-highlights-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .pdp-meta-list {
        font-size: 12.5px;
        color: #475569;
        line-height: 1.9;
    }
    .pdp-meta-list strong {
        color: #0F172A;
        font-weight: 600;
        min-width: 85px;
        display: inline-block;
    }
    .pdp-meta-divider {
        width: 1px;
        height: 52px;
        background: #E2E8F0;
    }
    .pdp-highlights-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0F172A;
    }
    .pdp-highlight-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pdp-highlight-item i {
        color: var(--kkt-primary, #0B6FAE);
        font-size: 17px;
    }

    /* Push info column down so the title lines up with the image card */
    @media (min-width: 992px) {
        .pdp-info-col {
            padding-top: 22px;
        }
    }

    /* ============================================================
       TABS & FEATURE HIGHLIGHTS
    ============================================================ */
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
        padding: 11px 26px;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
        border: 1px solid #E2E8F0;
        border-bottom: none;
        background: #F1F5F9;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .pdp-tab-btn.active {
        background: var(--kkt-primary, #0B6FAE) !important;
        color: #FFFFFF !important;
        border-color: var(--kkt-primary, #0B6FAE) !important;
    }
    .pdp-tab-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 0 12px 12px 12px;
        padding: 26px 28px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.02);
    }

    /* 4-Feature Highlights Bar inside Description Tab */
    .pdp-features-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        padding-top: 24px;
        border-top: 1px solid #F1F5F9;
        margin-top: 24px;
    }
    .pdp-feature-col {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .pdp-feature-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1.5px solid var(--kkt-primary, #0B6FAE);
        color: var(--kkt-primary, #0B6FAE);
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #FFFFFF;
    }
    .pdp-feature-title {
        font-size: 13px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.2;
    }
    .pdp-feature-desc {
        font-size: 11.5px;
        color: #64748B;
        margin-top: 2px;
    }

    /* Specifications Table */
    .pdp-specs-table {
        width: 100%;
        margin-bottom: 0;
    }
    .pdp-specs-table tr {
        border-bottom: 1px solid #F1F5F9;
    }
    .pdp-specs-table tr:last-child {
        border-bottom: none;
    }
    .pdp-specs-table th {
        width: 25%;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #0F172A;
        background: #F8FAFC;
        border-radius: 6px;
    }
    .pdp-specs-table td {
        padding: 12px 18px;
        font-size: 13px;
        color: #475569;
    }

    /* Related Products Section */
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
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
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

    /* ============================================================
       RESPONSIVE BREAKPOINTS (MOBILE VIEW PERFECTION)
    ============================================================ */
    @media (max-width: 991px) {
        .pdp-gallery-sticky {
            position: static;
        }
        .pdp-product-title {
            font-size: 28px;
        }
        .pdp-luxury-tagline {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .pdp-top-header {
            flex-direction: column;
            gap: 8px;
        }
        .pdp-product-title {
            font-size: 24px;
        }
        .pdp-price-current,
        .pdp-price-old {
            font-size: 18px;
        }
        .pdp-trust-bar {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .pdp-meta-highlights-box {
            flex-direction: column;
            align-items: flex-start;
        }
        .pdp-meta-divider {
            width: 100%;
            height: 1px;
            margin: 4px 0;
        }
        .pdp-features-bar {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .pdp-tab-card {
            border-radius: 12px;
            padding: 20px 16px;
        }
        .pdp-related-title {
            font-size: 26px;
        }
        .pdp-thumbs-row {
            gap: 8px;
        }
        .pdp-thumb-item {
            width: 60px;
            height: 60px;
        }
        .pdp-specs-table th {
            width: 35%;
        }
    }

    @media (max-width: 576px) {
        .pdp-qty-wishlist-row {
            gap: 10px;
        }
        .pdp-btn-wishlist {
            flex: 1 1 auto;
            padding: 0 14px !important;
            font-size: 12.5px !important;
        }
        .pdp-features-bar {
            grid-template-columns: 1fr;
            gap: 14px;
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
                        {{-- Top Left Badge --}}
                        <span class="pdp-arrival-badge">
                            {{ $product->is_new_arrival ? 'New Arrival' : ($product->is_best_seller ? 'Best Seller' : 'Exclusive') }}
                        </span>

                        {{-- Top Right Zoom Icon Button --}}
                        <button type="button" class="pdp-zoom-btn" onclick="openZoomModal()" title="Zoom Image" aria-label="Zoom Image">
                            <i class="bi bi-search"></i>
                        </button>

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

                        {{-- Bottom Center Zoom Pill --}}
                        <button type="button" class="pdp-click-zoom-pill" onclick="openZoomModal()" aria-label="Click to zoom image">
                            <i class="bi bi-zoom-in"></i> Click to zoom
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
                {{-- Header with Category --}}
                <div class="pdp-top-header">
                    <div>
                        {{-- <span class="pdp-category-dash">
                            — {{ strtoupper($product->category->name ?? 'LUXURY COLLECTION') }} —
                        </span> --}}
                        <h1 class="pdp-product-title">{{ $product->name }}</h1>
                    </div>
                </div>

                {{-- Key Highlights Callout --}}
                @php
                    // Bold line (<strong>) = bullet. Following non-bold line = sub-line of that bullet (no dot).
                    // If nothing is bold, every line becomes its own bullet ("Lead — Sub" splits into lead + sub).
                    $bullets = [];
                    $short = (string) $product->short_description;
                    if (trim(strip_tags($short)) !== '') {
                        $txt = preg_replace('/<\s*br\s*\/?>|<\/\s*(p|div|li|h[1-6])\s*>/i', "\n", $short);
                        $txt = strip_tags($txt, '<strong><b><em><i>');
                        $txt = preg_replace('/<(strong|b|em|i)\b[^>]*>/i', '<$1>', $txt);
                        // Jodit/other editors may leave &nbsp; or raw non-breaking spaces
                        $txt = preg_replace('/&nbsp;|&#160;|\x{00A0}/u', ' ', $txt);
                        $trimU = fn($v) => preg_replace('/^[\s\x{00A0}]+|[\s\x{00A0}]+$/u', '', $v);
                        $lines = collect(preg_split('/\r\n|\r|\n/', $txt))
                            ->map(fn($l) => $trimU($l))
                            ->filter(fn($l) => $trimU(strip_tags($l)) !== '')
                            ->values();
                        $hasBold = $lines->contains(fn($l) => preg_match('/^<(strong|b)>/i', $l));
                        foreach ($lines as $l) {
                            if ($hasBold) {
                                if (preg_match('/^<(strong|b)>/i', $l) || empty($bullets)) {
                                    if (preg_match('/^(<(strong|b)>.*?<\/\2>)\s*(.+)$/is', $l, $m) && trim(strip_tags($m[3])) !== '') {
                                        $bullets[] = ['lead' => $m[1], 'sub' => $m[3]];
                                    } else {
                                        $bullets[] = ['lead' => $l, 'sub' => null];
                                    }
                                } else {
                                    $last = count($bullets) - 1;
                                    $bullets[$last]['sub'] = $bullets[$last]['sub'] ? $bullets[$last]['sub'] . ' ' . $l : $l;
                                }
                            } else {
                                $parts = preg_split('/\s+—\s+/', $l, 2);
                                $bullets[] = ['lead' => $parts[0], 'sub' => $parts[1] ?? null];
                            }
                        }
                    }
                @endphp
                @if(count($bullets))
                <div class="pdp-callout-box">
                    <ul>
                        @foreach($bullets as $b)
                            <li>
                                <span class="callout-lead">{!! $b['lead'] !!}</span>
                                @if($b['sub'])
                                    <span class="callout-sub">{!! $b['sub'] !!}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Price Area --}}
                <div class="pdp-price-row">
                    @if($product->sale_price && (float)$product->sale_price < (float)$product->price)
                        {{-- 1. Regular Price with Cut-mark (Line through) --}}
                        <span id="display-old-price" class="pdp-price-old" style="text-decoration: line-through !important;">
                            ₹{{ number_format($product->price, 2) }}
                        </span>
                        {{-- 2. Sale Price without Line --}}
                        <span id="display-price" class="pdp-price-current" style="text-decoration: none !important;">
                            ₹{{ number_format($product->sale_price, 2) }}
                        </span>
                        {{-- 3. Discount Percentage --}}
                        <span id="display-discount" class="pdp-discount-pill">
                            {{ $product->discount_percent }}% off
                        </span>
                    @else
                        <span id="display-old-price" class="pdp-price-old" style="display: none; text-decoration: line-through !important;"></span>
                        <span id="display-price" class="pdp-price-current" style="text-decoration: none !important;">
                            ₹{{ number_format($product->price, 2) }}
                        </span>
                        <span id="display-discount" class="pdp-discount-pill" style="display: none;"></span>
                    @endif
                </div>
                <div class="pdp-mrp-caption">MRP(Inclusive of all taxes)</div>

                {{-- Color Swatch & Variants --}}
                @php
                    $colors = $product->variants->whereNotNull('color')->unique('color');
                    $sizes  = $product->variants->whereNotNull('size')->unique('size');
                @endphp

                {{-- Sizes if any --}}
                @if($sizes->count())
                <div class="mb-3">
                    <div class="pdp-color-label">Size: <span id="selected-size">—</span></div>
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

                {{-- Quantity + Wishlist (compact row) --}}
                <div class="pdp-qty-wishlist-row">
                    <div class="pdp-qty-selector">
                        <button type="button" onclick="changeQty(-1)" class="pdp-qty-btn" aria-label="Decrease quantity">−</button>
                        <input type="number" id="qty-input" value="1" min="1" max="{{ $product->stock ?: 99 }}" class="pdp-qty-input" aria-label="Quantity">
                        <button type="button" onclick="changeQty(1)" class="pdp-qty-btn" aria-label="Increase quantity">+</button>
                    </div>

                   
                </div>

                {{-- Customisation / Add to Cart / Join Live Demo --}}
                <div class="pdp-stacked-actions">
                    <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}&type=customisation"
                       class="btn pdp-btn-ref pdp-btn-blue pdp-btn-small">
                        Customisation
                    </a>

                    @if($product->isInStock())
                    <button type="button"
                            class="btn pdp-btn-ref pdp-btn-blue pdp-btn-wide btn-add-to-cart"
                            id="main-add-to-cart"
                            data-product-id="{{ $product->id }}">
                        Add to Cart
                    </button>
                    @else
                    <button type="button" class="btn pdp-btn-ref pdp-btn-blue pdp-btn-wide disabled" disabled>
                        Out of Stock
                    </button>
                    @endif

                    <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}&type=live-demo"
                       class="btn pdp-btn-ref pdp-btn-grey pdp-btn-wide">
                        Join Live Demo
                    </a>
                </div>

                {{-- White card: Trust bar + Meta box --}}
                <div class="pdp-info-card">
                {{-- 3-Column Trust Highlights Bar --}}
                <div class="pdp-trust-bar">
                    <div class="pdp-trust-cell">
                        <div class="pdp-trust-icon-box">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <div class="pdp-trust-title">Free Shipping</div>
                            <div class="pdp-trust-sub">On orders above ₹999</div>
                        </div>
                    </div>
                    <div class="pdp-trust-cell">
                        <div class="pdp-trust-icon-box">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="pdp-trust-title">Secure Payment</div>
                            <div class="pdp-trust-sub">100% safe and secure</div>
                        </div>
                    </div>
                    <div class="pdp-trust-cell">
                        <div class="pdp-trust-icon-box">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div>
                            <div class="pdp-trust-title">Easy Returns</div>
                            <div class="pdp-trust-sub">7 days return policy</div>
                        </div>
                    </div>
                </div>

                {{-- Meta Information & Highlights Box --}}
                <div class="pdp-meta-highlights-box">
                    <div class="pdp-meta-list">
                        <div><strong>SKU:</strong> {{ $product->sku ?: 'FBD-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <div><strong>Category:</strong> {{ $product->category->name ?? 'General' }}</div>
                        <div>
                            <strong>Availability:</strong>
                            @if($product->isInStock())
                            <span class="text-success fw-bold">✓ In Stock</span>
                            @else
                            <span class="text-danger fw-bold">✗ Out of Stock</span>
                            @endif
                        </div>
                    </div>

                    <div class="pdp-meta-divider"></div>

                    <div class="pdp-highlights-list">
                        <div class="pdp-highlight-item">
                            <i class="bi bi-gem"></i>
                            <span>Premium Quality</span>
                        </div>
                        <div class="pdp-highlight-item">
                            <i class="bi bi-feather"></i>
                            <span>Handcrafted Product</span>
                        </div>
                    </div>
                </div>
                </div>{{-- /pdp-info-card --}}
            </div>
        </div>

        {{-- ============================================================
             TABS: DESCRIPTION, SPECIFICATIONS, REVIEWS
        ============================================================ --}}
        <div class="row mt-5 pt-2">
            <div class="col-12">
                {{-- Tabs Navigation --}}
                <div class="pdp-tabs-nav" id="pdpTabNav">
                    <button class="pdp-tab-btn active" data-bs-toggle="tab" data-bs-target="#pdp-tab-description">
                        Description
                    </button>
                    <button class="pdp-tab-btn" data-bs-toggle="tab" data-bs-target="#pdp-tab-specifications">
                        Specifications
                    </button>
                    <button class="pdp-tab-btn" data-bs-toggle="tab" data-bs-target="#pdp-tab-reviews">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </div>

                {{-- Tab Content Card --}}
                <div class="pdp-tab-card">
                    <div class="tab-content" id="pdpTabContent">
                        {{-- Tab 1: Description --}}
                        <div class="tab-pane fade show active" id="pdp-tab-description">
                            <div class="pdp-desc-body" style="font-size: 13.5px; color: #475569; line-height: 1.8;">
                                @if($product->description)
                                    {!! $product->description !!}
                                @else
                                    <p>{{ $product->name }} from Finesse By Design. Premium handcrafted metal giftware. Designed with meticulous attention to detail to bring timeless luxury and elegance to your tableware collection.</p>
                                @endif
                            </div>

                            {{-- 4-Feature Highlights Bar inside card --}}
                            <div class="pdp-features-bar">
                                <div class="pdp-feature-col">
                                    <div class="pdp-feature-icon-wrap">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <div class="pdp-feature-info">
                                        <div class="pdp-feature-title">Premium Quality</div>
                                        <div class="pdp-feature-desc">Finest craftsmanship</div>
                                    </div>
                                </div>

                                <div class="pdp-feature-col">
                                    <div class="pdp-feature-icon-wrap">
                                        <i class="bi bi-feather"></i>
                                    </div>
                                    <div class="pdp-feature-info">
                                        <div class="pdp-feature-title">Handcrafted</div>
                                        <div class="pdp-feature-desc">By skilled artisans</div>
                                    </div>
                                </div>

                                <div class="pdp-feature-col">
                                    <div class="pdp-feature-icon-wrap">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="pdp-feature-info">
                                        <div class="pdp-feature-title">Perfect for Gifting</div>
                                        <div class="pdp-feature-desc">Adds elegance to every occasion</div>
                                    </div>
                                </div>

                                <div class="pdp-feature-col">
                                    <div class="pdp-feature-icon-wrap">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="pdp-feature-info">
                                        <div class="pdp-feature-title">Long lasting</div>
                                        <div class="pdp-feature-desc">Designed to be timeless</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 2: Specifications --}}
                        <div class="tab-pane fade" id="pdp-tab-specifications">
                            <table class="pdp-specs-table">
                                <tbody>
                                    <tr>
                                        <th>SKU / Catalogue Code</th>
                                        <td>{{ $product->sku ?: 'FBD-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $product->category->name ?? 'Tableware' }}</td>
                                    </tr>
                                    @if($product->subcategory)
                                    <tr>
                                        <th>Subcategory</th>
                                        <td>{{ $product->subcategory->name }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Material / Finish</th>
                                        <td>100% Handcrafted Brass / Metalware</td>
                                    </tr>
                                    @if($product->dimensions)
                                    <tr>
                                        <th>Dimensions</th>
                                        <td>{{ $product->dimensions }}</td>
                                    </tr>
                                    @endif
                                    @if($product->weight)
                                    <tr>
                                        <th>Weight</th>
                                        <td>{{ $product->weight }} grams</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Care Instructions</th>
                                        <td>Clean gently with a soft dry cotton cloth. Avoid abrasive cleaners or harsh chemicals to preserve lustrous brass polish.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Tab 3: Reviews --}}
                        <div class="tab-pane fade" id="pdp-tab-reviews">
                            {{-- Write a Review Section --}}
                            @auth
                            <div class="border rounded-4 p-4 mb-4 bg-light">
                                <h5 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Write a Review</h5>
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
                                        <textarea name="body" rows="4" class="form-control" placeholder="Share your experience with this luxury product..." style="border-radius: 8px;" required></textarea>
                                    </div>
                                    <button class="btn pdp-btn-cart px-4">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="alert alert-light border rounded-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>Please <a href="{{ route('login') }}" class="text-decoration-underline fw-bold" style="color: var(--kkt-primary);">log in</a> to share your review with other connoisseurs.</div>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Log In</a>
                            </div>
                            @endauth

                            {{-- Existing Reviews List --}}
                            @forelse($product->reviews as $review)
                            <div class="d-flex gap-3 border-bottom pb-3 mb-3">
                                <img src="{{ $review->user->avatar_url }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="{{ $review->user->name }}">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong style="font-size:.9rem; color: #0F172A;">{{ $review->user->name }}</strong>
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
             RELATED PRODUCTS SECTION
        ============================================================ --}}
        @php
            // 1) controller's $related  2) same category  3) any other products
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
                b.style.border = '2px solid #E2E8F0';
                b.style.boxShadow = 'none';
            });
            this.style.border = '2px solid #FFFFFF';
            this.style.boxShadow = '0 0 0 2px #0F172A';
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
        const size  = document.getElementById('selected-size')?.textContent;
        if (!variants || !variants.length) return;

        const variant = variants.find(v => (!color || v.color === color) && (!size || v.size === size));
        if (variant) {
            selectedVariantId = variant.id;
            const price = variant.price ? parseFloat(variant.price) : {{ (float)$product->price }};
            const salePrice = variant.sale_price ? parseFloat(variant.sale_price) : null;

            const oldPriceDisplay = document.getElementById('display-old-price');
            const priceDisplay    = document.getElementById('display-price');
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
                    discountDisplay.textContent = pct + '% off';
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
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
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

    // Robust Tab switching logic
    function switchPdpTab(targetSelector) {
        if (!targetSelector) return;
        // Update tab buttons
        document.querySelectorAll('.pdp-tab-btn').forEach(btn => {
            const isMatch = btn.getAttribute('data-bs-target') === targetSelector;
            btn.classList.toggle('active', isMatch);
        });

        // Update tab panes
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