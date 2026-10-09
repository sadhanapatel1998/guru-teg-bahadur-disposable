@extends('layouts.app')

@section('title', 'Stories & Craftsmanship | The Brass & Decor Journal')
@section('meta_description', 'Discover design inspirations, gifting guides, and stories of artisanal brass craftsmanship from Finesse By Designed.')

@section('content')
 <div class="breadcrumb-kkt">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </nav>
    </div>
</div>
<section class="luxury-blog-listing-section">
    <div class="container">

        {{-- Top Luxury Breadcrumb --}}
       

        {{-- Section Luxury Header --}}
        <div class="section-luxury-header mb-5 text-center">
            <div class="section-luxury-header-content">
                <div class="sec-explore-tag">
                    <span class="tag-line"></span>
                    <span class="tag-text">STORIES & INSIGHTS</span>
                    <span class="tag-line"></span>
                </div>
                <h1 class="sec-main-heading">
                    The Disposables & Catering <span class="sec-heading-accent">Journal</span>
                </h1>
                <p class="sec-desc mx-auto" style="max-width: 680px;">
                    Explore curated guides, catering tips, party essentials, and quality disposable tableware inspirations.
                </p>
            </div>
        </div>

        {{-- Blog Grid: 3-Column Luxury Cards (Categories Sidebar Removed) --}}
        <div class="row g-4 justify-content-start">
            @forelse($blogs as $blog)
                @php
                    $words = str_word_count(strip_tags($blog->body ?? ($blog->excerpt ?? '')));
                    $readMin = max(1, ceil($words / 200));
                    $catName = $blog->blogCategory->name ?? ($blog->category->name ?? 'Cutlery');
                    $catSlug = strtolower($blog->blogCategory->slug ?? ($blog->category->slug ?? ''));

                    $themes = [
                        ['class' => 'theme-orange', 'accent' => '#EA580C', 'bg' => '#FFEDD5', 'icon' => 'cutlery'],
                        ['class' => 'theme-green',  'accent' => '#16A34A', 'bg' => '#DCFCE7', 'icon' => 'cutlery'],
                        ['class' => 'theme-rose',   'accent' => '#E11D48', 'bg' => '#FFE4E6', 'icon' => 'bar-range'],
                    ];
                    $theme = $themes[$loop->index % 3];

                    $isBar = str_contains($catSlug, 'bar') || str_contains(strtolower($catName), 'bar');
                    $iconType = $isBar ? 'bar-range' : ($theme['icon'] ?? 'cutlery');
                    $dateStr = $blog->published_at ? $blog->published_at->format('d M Y') : ($blog->created_at ? $blog->created_at->format('d M Y') : date('d M Y'));
                @endphp
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none h-100 d-block">
                        <article class="luxury-article-card {{ $theme['class'] }}">
                            {{-- Image Wrapper --}}
                            <div class="article-img-wrap">
                                <img src="{{ $blog->thumbnail_url }}"
                                     alt="{{ $blog->title }}"
                                     loading="lazy"
                                     onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                                {{-- Floating Category Pill Badge --}}
                                <span class="article-cat-badge">
                                    @if($iconType === 'bar-range')
                                        <svg class="cat-pill-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 22h8"/>
                                            <path d="M12 15v7"/>
                                            <path d="M5 3l7 9 7-9H5z"/>
                                        </svg>
                                    @else
                                        <svg class="cat-pill-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 2v20M21 2c0 2.5-1 4.5-3 5.5"/>
                                            <path d="M6 2v6a2 2 0 0 0 2 2v12"/>
                                            <path d="M4 2v5"/>
                                            <path d="M8 2v5"/>
                                        </svg>
                                    @endif
                                    <span>{{ strtoupper($catName) }}</span>
                                </span>
                            </div>

                            {{-- Body Content --}}
                            <div class="article-body">
                                {{-- Meta Row: Date & Read Time --}}
                                <div class="article-meta-row">
                                    <span class="meta-item">
                                        <i class="bi bi-calendar3"></i>
                                        <span>{{ $dateStr }}</span>
                                    </span>
                                    <span class="article-meta-divider">|</span>
                                    <span class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $readMin }} min read</span>
                                    </span>
                                </div>

                                {{-- Article Title --}}
                                <h3 class="article-title" title="{{ $blog->title }}">
                                    {{ Str::limit($blog->title, 58) }}
                                </h3>

                                {{-- Article Excerpt --}}
                                <p class="article-excerpt">
                                    {{ Str::limit($blog->excerpt ?? strip_tags($blog->body), 115) }}
                                </p>

                                {{-- Footer Action Row --}}
                                <div class="article-card-footer">
                                    <div class="article-read-story">
                                        <span>Read Full Story</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </div>
                                    <span class="article-circle-btn">
                                        <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 520px;">
                        <i class="bi bi-journal-text text-muted" style="font-size: 3.2rem;"></i>
                        <h4 class="mt-3 fw-bold" style="color: var(--kkt-dark, #1E293B);">No Stories Published Yet</h4>
                        <p class="text-muted mb-4" style="font-size: 0.92rem;">
                            Our artisans and stylists are crafting new articles. Check back soon for guides and stories!
                        </p>
                        <a href="{{ route('home') }}" class="btn px-4 py-2 text-white fw-semibold rounded-pill" style="background: var(--kkt-gradient, linear-gradient(135deg, #0A4F7D, #118CC4));">
                            Return Home
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Luxury Centered Pagination (Only displayed when more than 6 posts / multiple pages) --}}
        @if($blogs->hasPages())
            <div class="luxury-pagination-wrapper d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
