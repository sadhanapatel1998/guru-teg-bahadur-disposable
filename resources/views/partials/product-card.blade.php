@php
    $wished = auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists();

    // Clean, concise category tag matching the mockup (e.g. PLATES, SPOONS, BOWLS)
    $shortBadge = 'DISPOSABLES';
    $nameLower = strtolower(($product->name ?? '') . ' ' . ($product->category?->name ?? ''));
    if (str_contains($nameLower, 'spoon') || str_contains($nameLower, 'fork') || str_contains($nameLower, 'cutlery')) {
        $shortBadge = 'SPOONS';
    } elseif (str_contains($nameLower, 'plate') || str_contains($nameLower, 'thali') || str_contains($nameLower, 'tray')) {
        $shortBadge = 'PLATES';
    } elseif (str_contains($nameLower, 'bowl')) {
        $shortBadge = 'BOWLS';
    } elseif (str_contains($nameLower, 'cup') || str_contains($nameLower, 'glass')) {
        $shortBadge = 'CUPS';
    } elseif (str_contains($nameLower, 'foil') || str_contains($nameLower, 'roll')) {
        $shortBadge = 'FOILS';
    } elseif (str_contains($nameLower, 'tissue') || str_contains($nameLower, 'napkin')) {
        $shortBadge = 'TISSUE';
    } elseif (!empty($product->category?->name)) {
        $words = preg_split('/\s+/', trim($product->category->name));
        $shortBadge = strtoupper($words[0] ?? 'ITEM');
    }

    // Discount percentage calculation
    $discountPercent = 0;
    if (isset($product->discount_percent) && $product->discount_percent > 0) {
        $discountPercent = round($product->discount_percent);
    } elseif ($product->price > 0 && $product->effective_price < $product->price) {
        $discountPercent = round((($product->price - $product->effective_price) / $product->price) * 100);
    }

    // Clean, subtle pastel background palette (pure backdrop only - NEVER alters product)
    $pastelPalette = [
        ['bg' => '#E8F4FC', 'badge_bg' => '#D4EBF9', 'badge_color' => '#0284C7'], // soft blue (Plates)
        ['bg' => '#FEF7EC', 'badge_bg' => '#FDECCF', 'badge_color' => '#B45309'], // warm cream (Plates)
        ['bg' => '#FEECEE', 'badge_bg' => '#FDD7DB', 'badge_color' => '#DC2626'], // soft pink/rose (Spoons)
        ['bg' => '#FEF3E2', 'badge_bg' => '#FDE6C8', 'badge_color' => '#B45309'], // warm amber (Spoons)
        ['bg' => '#F4ECFD', 'badge_bg' => '#E9D8FB', 'badge_color' => '#7C3AED'], // soft lavender (Spoons)
        ['bg' => '#EAF8EE', 'badge_bg' => '#CEF2DA', 'badge_color' => '#16A34A'], // soft mint green (Bowls)
        ['bg' => '#E2F3FC', 'badge_bg' => '#CCE8F8', 'badge_color' => '#0284C7'], // soft sky cyan (Bowls)
        ['bg' => '#FFEBF0', 'badge_bg' => '#FDD5DE', 'badge_color' => '#E11D48'], // soft rose (Bowls)
    ];
    $paletteIndex = ($product->id ?? 0) % count($pastelPalette);
    $palette = $pastelPalette[$paletteIndex];
@endphp

<div class="{{ $colClass ?? 'col-xl-3 col-lg-4 col-md-6 col-6' }}">
    <div class="product-card">
        {{-- Product Image Container with Subtle Pastel Backdrop --}}
        <div class="card-img-wrapper" style="background-color: {{ $palette['bg'] }};">
            <a href="{{ route('product.show', $product->slug) }}" class="card-img-link">
                <img src="{{ $product->thumbnail_url }}"
                    alt="{{ $product->name }}"
                    loading="lazy"
                    onerror="this.onerror=null;this.src='{{ base_public_url('assets/img/no-products.png') }}';">
            </a>

            {{-- Top-Left Category Badge (Clean, short name) --}}
            <span class="prod-category-pill" style="background: {{ $palette['badge_bg'] }}; color: {{ $palette['badge_color'] }};">
                {{ $shortBadge }}
            </span>

            {{-- Top-Right Wishlist Button --}}
            <button type="button"
                    class="prod-wishlist-circle btn-wishlist {{ $wished ? 'wishlisted' : '' }}"
                    data-product-id="{{ $product->id }}"
                    title="Wishlist"
                    aria-label="Wishlist">
                <i class="bi bi-heart{{ $wished ? '-fill' : '' }}"></i>
            </button>
        </div>

        {{-- Product Information Body --}}
        <div class="card-body">
            {{-- Product Title --}}
            <a href="{{ route('product.show', $product->slug) }}" class="prod-title-link">
                <h3 class="prod-title" title="{{ $product->name }}">{{ $product->name }}</h3>
            </a>

            {{-- Price & Discount Row --}}
            <div class="prod-price-row">
                <div class="prod-price-group">
                    <span class="prod-price-current">₹{{ number_format($product->effective_price) }}</span>
                    @if($product->price > $product->effective_price)
                        <span class="prod-price-original">₹{{ number_format($product->price) }}</span>
                    @endif
                </div>

                @if($discountPercent > 0)
                    <span class="prod-discount-badge">{{ $discountPercent }}% OFF</span>
                @endif
            </div>

            {{-- Add to Cart Full-Width Action Button --}}
            @if($product->isInStock())
                <button type="button"
                        class="prod-add-cart-btn btn-add-to-cart"
                        data-product-id="{{ $product->id }}"
                        title="Add to Cart">
                    <i class="bi bi-cart3"></i>
                    <span>Add to Cart</span>
                </button>
            @else
                <button type="button"
                        class="prod-add-cart-btn prod-add-cart-btn-disabled"
                        disabled
                        title="Out of Stock">
                    <i class="bi bi-cart-x"></i>
                    <span>Sold Out</span>
                </button>
            @endif
        </div>
    </div>
</div>

@once
<style>
/* ============================================================
   EXACT REPLICA: MODERN MINIMAL PRODUCT CARD (MATCHING SHARED IMAGE)
   The main product is completely unchanged (no blend modes, no filters, no tints).
   Only the background behind the product has a clean, subtle pastel tone.
============================================================ */
.product-card {
    position: relative;
    background: #FFFFFF;
    border: 1px solid #EEF2F6;
    border-radius: 20px;
    padding: 12px;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1),
                box-shadow 0.3s cubic-bezier(0.2, 0.8, 0.2, 1),
                border-color 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    border-color: #DCE5ED;
    box-shadow: 0 12px 28px rgba(11, 58, 99, 0.09);
}

/* ===== IMAGE WRAPPER ===== */
.product-card .card-img-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1.05 / 1;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-card .card-img-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    text-decoration: none;
}

/* Product image is preserved 100% natural and untouched: NO blend modes, NO filters, NO tints */
.product-card .card-img-wrapper img {
    width: 80%;
    height: 80%;
    object-position: center;
    display: block;
    mix-blend-mode: normal !important;
    filter: none !important;
    opacity: 1 !important;
    transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.product-card:hover .card-img-wrapper img {
    transform: scale(1.05);
}

/* ===== TOP-LEFT CATEGORY BADGE ===== */
.prod-category-pill {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 3;
    font-family: 'Poppins', sans-serif;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 4px 10px;
    border-radius: 8px;
    line-height: 1.1;
    pointer-events: none;
    max-width: 65%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* ===== TOP-RIGHT WISHLIST CIRCLE BUTTON ===== */
.prod-wishlist-circle {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #FFFFFF;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1E293B;
    font-size: 14px;
    cursor: pointer;
    z-index: 3;
    transition: transform 0.25s ease, box-shadow 0.25s ease, color 0.2s ease;
    padding: 0;
}

.prod-wishlist-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16);
    color: #DC2626;
}

.prod-wishlist-circle.wishlisted,
.prod-wishlist-circle.wishlisted i {
    color: #DC2626 !important;
}

/* ===== CARD BODY ===== */
.product-card .card-body {
    padding: 12px 2px 2px 2px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

/* ===== PRODUCT TITLE ===== */
.prod-title-link {
    text-decoration: none;
    display: block;
    margin-bottom: 2px;
}

.prod-title {
    font-family: 'Poppins', sans-serif;
    font-size: 15.5px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.3;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}

.prod-title-link:hover .prod-title {
    color: #0B3A63;
}

/* ===== PRICE & DISCOUNT ROW ===== */
.prod-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
     gap: 8px;
    margin-top: 8px;
    margin-bottom: 14px;
}


.prod-price-group {
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: nowrap;
}

.prod-price-current {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 800;
    color: #0B3A63;
    letter-spacing: -0.3px;
    line-height: 1;
    white-space: nowrap;
}

.prod-price-original {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #94A3B8;
    text-decoration: line-through;
    line-height: 1;
    white-space: nowrap;
}

.prod-discount-badge {
    background: #FEE2E2;
    color: #DC2626;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 50px;
    letter-spacing: 0.3px;
    white-space: nowrap;
    line-height: 1;
    margin-left: auto;
}

/* ===== FULL-WIDTH ADD TO CART BUTTON ===== */
.prod-add-cart-btn {
    width: 100% !important;
    height: 42px !important;
    border-radius: 10px !important;
    background: #0B3A63 !important; /* Guru Teg Bahadur deep navy */
    border: none !important;
    padding: 0 16px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    color: #FFFFFF !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    letter-spacing: 0.2px !important;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(11, 58, 99, 0.15);
    margin-top: auto !important;
}

.prod-add-cart-btn i {
    font-size: 15px !important;
    color: #FFFFFF !important;
    transition: transform 0.2s ease;
}

.prod-add-cart-btn:hover {
    background: #062A49 !important;
    box-shadow: 0 6px 16px rgba(11, 58, 99, 0.28);
    transform: translateY(-2px);
}

.prod-add-cart-btn:hover i {
    transform: scale(1.1);
}

.prod-add-cart-btn:active {
    transform: translateY(0);
}

.prod-add-cart-btn-disabled {
    background: #94A3B8 !important;
    box-shadow: none !important;
    cursor: not-allowed !important;
    opacity: 0.85;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 575px) {
    .product-card {
        padding: 9px;
        border-radius: 16px;
    }
    .product-card .card-img-wrapper {
        border-radius: 13px;
    }
    .prod-category-pill {
        font-size: 9px;
        padding: 3px 7px;
        top: 8px;
        left: 8px;
    }
    .prod-wishlist-circle {
        width: 28px;
        height: 28px;
        font-size: 12px;
        top: 8px;
        right: 8px;
    }
    .product-card .card-body {
        padding: 10px 0 0 0;
    }
    .prod-title {
        font-size: 13.5px;
    }
    .prod-price-row {
        gap: 6px;
        margin-top: 4px;
        margin-bottom: 9px;
    }
    .prod-price-current {
        font-size: 15px;
    }
    .prod-price-original {
        font-size: 11px;
    }
    .prod-discount-badge {
        font-size: 9.5px;
        padding: 2.5px 6px;
    }
    .prod-add-cart-btn {
        height: 35px !important;
        font-size: 12px !important;
        padding: 0 10px !important;
        gap: 6px !important;
        border-radius: 8px !important;
    }
    .prod-add-cart-btn i {
        font-size: 13px !important;
    }
}
</style>
@endonce