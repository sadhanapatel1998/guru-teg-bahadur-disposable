@extends('layouts.app')
@section('title', setting('site_name', 'Sanni Cad Cam'))

@section('content')

    {{-- Hero Slider --}}
    @if ($banners->count())

        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            {{-- Indicators --}}
            <div class="carousel-indicators">
                @foreach ($banners as $i => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}">
                    </button>
                @endforeach
            </div>

            {{-- Slides --}}
            <div class="carousel-inner">

                @foreach ($banners as $i => $banner)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">

                        @if ($banner->link)
                            <a href="{{ $banner->link }}">
                        @endif

                        {{-- Desktop Image --}}
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                            class="w-100 d-none d-md-block hero-banner-img">

                        {{-- Mobile Image --}}
                        <img src="{{ $banner->mobile_image ? asset('public/storage/' . $banner->mobile_image) : $banner->image_url }}"
                            alt="{{ $banner->title }}" class="w-100 d-block d-md-none hero-banner-mobile-img">

                        @if ($banner->link)
                            </a>
                        @endif

                    </div>
                @endforeach

            </div>

            {{-- Controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>
            </button>

        </div>
    @else
        {{-- Default Banner --}}
        <div class="hero-default-banner">

            {{-- Desktop --}}
            <img src="{{ base_public_url('assets/img/dummy.png') }}" alt="Banner"
                class="w-100 d-none d-md-block hero-banner-img">

            {{-- Mobile --}}
            <img src="{{ base_public_url('assets/img/dummy.png') }}" alt="Banner"
                class="w-100 d-block d-md-none hero-banner-mobile-img">

        </div>

    @endif





    @if ($featuredCategories->count())

    <section class="cat-slide-section">
        <div class="container-fluid px-lg-5">
            {{-- Header Section --}}
            <div class="cat-section-header">
                {{-- Center Content --}}
                <div class="cat-header-content text-center">
                    <div class="cat-explore-tag">
                        <span class="tag-line"></span>
                        <span class="tag-text">EXPLORE OUR RANGE</span>
                        <span class="tag-line"></span>
                    </div>
                    <h2 class="cat-main-heading">
                        Shop by <span class="cat-heading-accent">Category</span>
                    </h2>
                    <p class="cat-desc">
                        Discover thoughtfully curated collections for every occasion, because every gift tells a story.
                    </p>
                </div>
            </div>

            {{-- Slider Container --}}
            <div class="cat-swiper-outer">
                <button type="button" class="cat-nav-btn cat-prev" aria-label="Previous categories">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="swiper cat-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($featuredCategories as $cat)
                            <div class="swiper-slide">
                                <a href="{{ route('shop.category', $cat->slug) }}" class="cat-circle-card">
                                    <div class="cat-circle-media">
                                        <svg class="cat-ring-svg" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <circle class="ring-arc ring-arc-red" cx="70" cy="70" r="66" stroke="#D9232E" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="115 300" stroke-dashoffset="15"/>
                                            <circle class="ring-arc ring-arc-blue" cx="70" cy="70" r="66" stroke="#0B3A63" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="115 300" stroke-dashoffset="225"/>
                                        </svg>
                                        <div class="cat-circle-img-wrap">
                                            @if ($cat->image)
                                                <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="cat-circle-img" loading="lazy">
                                            @else
                                                <img src="{{ base_public_url('assets/img/no-category.jpg') }}" alt="{{ $cat->name }}" class="cat-circle-img" loading="lazy">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="cat-card-body">
                                        <h6 class="cat-card-title">{{ $cat->name }}</h6>
                                        <span class="cat-card-btn" aria-label="Explore {{ $cat->name }}">
                                            <i class="bi bi-arrow-right"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button" class="cat-nav-btn cat-next" aria-label="Next categories">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    @once
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Swiper('.cat-swiper', {
                    slidesPerView: 6,
                    spaceBetween: 14,
                    navigation: {
                        nextEl: '.cat-next',
                        prevEl: '.cat-prev',
                    },
                    breakpoints: {
                        0:    { slidesPerView: 2.3, spaceBetween: 10 },
                        420:  { slidesPerView: 2.7, spaceBetween: 10 },
                        576:  { slidesPerView: 3.4, spaceBetween: 12 },
                        768:  { slidesPerView: 4.4, spaceBetween: 12 },
                        992:  { slidesPerView: 5.5, spaceBetween: 14 },
                        1200: { slidesPerView: 6.8, spaceBetween: 14 },
                        1400: { slidesPerView: 7,   spaceBetween: 14 },
                    }
                });
            });
        </script>
    @endonce

@endif




    {{-- Featured Products --}}
    @php
        $homeFeatured = (isset($featuredProducts) && $featuredProducts->count()) ? $featuredProducts : $trendingProducts;
    @endphp
    @if ($homeFeatured && $homeFeatured->count())
        <section class="py-5" style="background: #EAF2F8;">
            <div class="container">
                <div class="position-relative mb-4">
                    <div class="section-luxury-header mb-0">
                        <div class="section-luxury-header-content">
                            <div class="sec-explore-tag">
                                <span class="tag-line"></span>
                                <span class="tag-text">CRAFTED FOR A BETTER TOMORROW</span>
                                <span class="tag-line"></span>
                            </div>
                            <h2 class="sec-main-heading">
                                Featured <span class="sec-heading-accent">Products</span>
                            </h2>
                            <p class="sec-desc">
                                Handpicked pieces to elevate your everyday moments
                            </p>
                        </div>
                    </div>
                    <div class="d-none d-md-block position-absolute end-0 top-50 translate-middle-y">
                        <a href="{{ route('shop') }}" class="btn-luxury-viewall">
                            <span>View All</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-3">
                    @foreach ($homeFeatured as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('shop') }}" class="btn-luxury-viewall">
                        <span>View All Products</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif
   
    {{-- Flash Sale / Special Offers --}}
    @if ($saleProducts->count())
        <section class="py-5" style="background: #FFF8F0;">
            <div class="container"> 
                <div class="section-luxury-header mb-4">
                    <div class="section-luxury-header-content">
                        <div class="sec-explore-tag">
                            <span class="tag-line"></span>
                            <span class="tag-text">CURATED SELECTION</span>
                            <span class="tag-line"></span>
                        </div>
                        <h2 class="sec-main-heading">
                            Special <span class="sec-heading-accent">Offers</span>
                        </h2>
                        <p class="sec-desc">
                            Carefully selected signature pieces at exceptional prices.
                        </p>
                    </div>
                </div>
                <div class="row g-3">
                    @foreach ($saleProducts as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- New Arrivals --}}
    @if ($newArrivals->count())
        <section class="py-5" style="background: #FFFAFA;">
            <div class="container">
                <div class="section-luxury-header mb-4">
                    <div class="section-luxury-header-content">
                        <div class="sec-explore-tag">
                            <span class="tag-line"></span>
                            <span class="tag-text">LATEST COLLECTION</span>
                            <span class="tag-line"></span>
                        </div>
                        <h2 class="sec-main-heading">
                            New <span class="sec-heading-accent">Arrivals</span>
                        </h2>
                        <p class="sec-desc">
                            Freshly crafted additions to our luxury tableware and barware collection.
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    @foreach ($newArrivals as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Best Sellers --}}
    @if ($bestSellers->count())
        <section class="py-5" style="background: #FAF4EB;">
            <div class="container">
                <div class="section-luxury-header mb-4">
                    <div class="section-luxury-header-content">
                        <div class="sec-explore-tag">
                            <span class="tag-line"></span>
                            <span class="tag-text">CUSTOMER FAVORITES</span>
                            <span class="tag-line"></span>
                        </div>
                        <h2 class="sec-main-heading">
                            Best <span class="sec-heading-accent">Sellers</span>
                        </h2>
                        <p class="sec-desc">
                            Most admired and frequently chosen signature pieces.
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    @foreach ($bestSellers as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Latest Blog / Articles --}}
    @if ($latestBlogs->count())
        <section class="py-5" style="
            background: radial-gradient(circle at bottom left, rgba(17,140,196,.04), transparent 30%),
                        linear-gradient(180deg, #FFFFFF 0%, #F6F9FB 100%);
        ">
            <div class="container">
                <div class="position-relative mb-4">
                    <div class="section-luxury-header mb-0">
                        <div class="section-luxury-header-content">
                            <div class="sec-explore-tag">
                                <span class="tag-line"></span>
                                <span class="tag-text">STORIES & INSPIRATION</span>
                                <span class="tag-line"></span>
                            </div>
                            <h2 class="sec-main-heading">
                                Latest <span class="sec-heading-accent">Articles</span>
                            </h2>
                            <p class="sec-desc">
                                Explore stories of timeless craftsmanship, design inspiration, and luxury living.
                            </p>
                        </div>
                    </div>
                    <div class="d-none d-md-block position-absolute end-0 top-50 translate-middle-y">
                        <a href="{{ route('blog.index') }}" class="btn-luxury-viewall">
                            <span>View All</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($latestBlogs as $blog)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none h-100 d-block">
                                <article class="luxury-article-card">
                                    {{-- Image Wrapper --}}
                                    <div class="article-img-wrap">
                                        <img src="{{ $blog->thumbnail_url }}"
                                             alt="{{ $blog->title }}"
                                             loading="lazy"
                                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                                        {{-- Category Badge --}}
                                        <span class="article-cat-badge">
                                            {{ $blog->blogCategory->name ?? 'Craftsmanship' }}
                                        </span>

                                        {{-- Published Date --}}
                                        <span class="article-date-badge">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $blog->published_at?->format('d M Y') }}
                                        </span>
                                    </div>

                                    {{-- Body Content --}}
                                    <div class="article-body">
                                        <div class="article-meta-row">
                                            <span><i class="bi bi-clock-history me-1"></i> 3 min read</span>
                                            <span>•</span>
                                            <span><i class="bi bi-gem me-1"></i> Luxury Living</span>
                                        </div>

                                        <h3 class="article-title" title="{{ $blog->title }}">
                                            {{ Str::limit($blog->title, 55) }}
                                        </h3>

                                        <p class="article-excerpt">
                                            {{ Str::limit($blog->excerpt, 105) }}
                                        </p>

                                        <div class="article-card-footer">
                                            <span class="article-read-text">Read Full Story</span>
                                            <span class="article-arrow-btn">
                                                <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('blog.index') }}" class="btn-luxury-viewall">
                        <span>View All Articles</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection


