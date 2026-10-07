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
                    The Brass & Decor <span class="sec-heading-accent">Journal</span>
                </h1>
                <p class="sec-desc mx-auto" style="max-width: 680px;">
                    Explore curated design guides, artisanal brass craftsmanship traditions, interior inspirations, and timeless living stories.
                </p>
            </div>
        </div>

        {{-- Blog Grid: 3-Column Luxury Cards (Categories Sidebar Removed) --}}
        <div class="row g-4 justify-content-start">
            @forelse($blogs as $blog)
                @php
                    $words = str_word_count(strip_tags($blog->body ?? ''));
                    $readMin = max(1, ceil($words / 200));
                    $catName = $blog->blogCategory->name ?? ($blog->category->name ?? 'Artisanal Brass');
                @endphp
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none h-100 d-block">
                        <article class="luxury-article-card">
                            {{-- Image Wrapper --}}
                            <div class="article-img-wrap">
                                <img src="{{ $blog->thumbnail_url }}"
                                     alt="{{ $blog->title }}"
                                     loading="lazy"
                                     onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                                {{-- Floating Category Pill Badge --}}
                                <span class="article-cat-badge">
                                    {{ $catName }}
                                </span>

                                {{-- Floating Published Date Badge --}}
                                <span class="article-date-badge">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                </span>
                            </div>

                            {{-- Body Content --}}
                            <div class="article-body">
                                <div class="article-meta-row">
                                    <span><i class="bi bi-clock-history me-1"></i> {{ $readMin }} min read</span>
                                    <span>•</span>
                                    <span><i class="bi bi-gem me-1"></i> Luxury Living</span>
                                </div>

                                <h3 class="article-title" title="{{ $blog->title }}">
                                    {{ Str::limit($blog->title, 55) }}
                                </h3>

                                <p class="article-excerpt">
                                    {{ Str::limit($blog->excerpt ?? strip_tags($blog->body), 105) }}
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
