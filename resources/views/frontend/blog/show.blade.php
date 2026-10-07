@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title)
@section('meta_description', $blog->meta_description ?? $blog->excerpt)

@php
    $wordCount = str_word_count(strip_tags($blog->body ?? ''));
    $readingTime = max(1, ceil($wordCount / 200));

    $authorName = $blog->admin?->name ?? 'Admin';
    $authorInitial = strtoupper(substr($authorName, 0, 1));

    $catSlug = $blog->blogCategory?->slug ?? $blog->category?->slug ?? '';
    $catName = $blog->blogCategory?->name ?? $blog->category?->name ?? 'Home Decor';

    // Map common category slugs / names to bootstrap icons
    $catIcons = [
        'home-decor'       => 'bi-house-door',
        'tableware'        => 'bi-cup',
        'gifting-ideas'    => 'bi-gift',
        'interior-trends'  => 'bi-lamp',
        'lifestyle'        => 'bi-feather',
        'tips-guides'      => 'bi-journal-text',
        'product-updates'  => 'bi-tag',
        'bar-range'        => 'bi-cup-straw',
        'cutlery'          => 'bi-slash-circle',
        'dessert-cups'     => 'bi-cup-hot',
        'flower-vase'      => 'bi-flower1',
        'gift-basket'      => 'bi-basket',
        'misc-articles'    => 'bi-collection',
    ];

    $currentUrl = url()->current();
    $shareTitle = urlencode($blog->title);
    $shareUrl   = urlencode($currentUrl);
@endphp

@section('content')
 <div class="breadcrumb-kkt">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
            </ol>
        </nav>
    </div>
</div>
<section class="blog-details-section">
    <div class="container">

        <div class="row g-4 g-lg-5 align-items-start">

    {{-- Main Content Column --}}
    <div class="col-lg-8">

        <div class="blog-main-card">

                {{-- Category Pill Badge --}}
                @if($catName)
                    <a href="{{ route('blog.index', ['category' => $catSlug]) }}" class="blog-detail-cat-badge">
                        {{ $catName }}
                    </a>
                @endif

                {{-- Blog Main Title --}}
                <h1 class="blog-detail-title">
                    {{ $blog->title }}
                </h1>

              
               

                {{-- Featured Hero Image --}}
                @if($blog->thumbnail)
                    <div class="blog-hero-wrap">
                        <img src="{{ $blog->thumbnail_url }}"
                             alt="{{ $blog->title }}"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                    </div>
                @endif
                 {{-- Author & Meta Information Bar --}}
                <div class="blog-meta-bar">
                    <div class="blog-meta-left">
                        {{-- Author Info --}}
                        <div class="blog-author-wrap">
                            <div class="blog-author-avatar">
                                {{ $authorInitial }}
                            </div>
                            <div>
                                <div class="blog-author-name">By {{ $authorName }}</div>
                                <div class="blog-author-role">Content Writer</div>
                            </div>
                        </div>

                        <div class="blog-meta-divider d-none d-sm-block"></div>

                        {{-- Published Date --}}
                        <div class="blog-meta-pill">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $blog->published_at?->format('M d, Y') ?? date('M d, Y') }}</span>
                        </div>

                        {{-- Views --}}
                        <div class="blog-meta-pill">
                            <i class="bi bi-eye"></i>
                            <span>{{ number_format(max(1, $blog->views)) }} views</span>
                        </div>

                        {{-- Reading Time --}}
                        <div class="blog-meta-pill">
                            <i class="bi bi-clock"></i>
                            <span>{{ $readingTime }} min read</span>
                        </div>
                    </div>

                    {{-- Social Share Icons --}}
                    <div class="blog-share-wrap">
                        <span class="blog-share-label">Share:</span>
                        <div class="blog-share-icons">
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="blog-share-btn"
                               title="Share on Facebook"
                               aria-label="Share on Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>

                            {{-- Twitter / X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="blog-share-btn"
                               title="Share on X"
                               aria-label="Share on X">
                                <i class="bi bi-twitter-x"></i>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="blog-share-btn"
                               title="Share on LinkedIn"
                               aria-label="Share on LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            {{-- Copy Link --}}
                            <button type="button"
                                    class="blog-share-btn border-0"
                                    id="btnCopyLink"
                                    onclick="copyBlogLink(this)"
                                    title="Copy Article Link"
                                    aria-label="Copy Article Link">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Article Body Content --}}
                <article class="blog-article-content">
                    {!! $blog->body !!}
                </article>

                {{-- Tags If Available --}}
                @if(!empty($blog->tags) && is_array($blog->tags) && count($blog->tags))
                    <div class="d-flex align-items-center flex-wrap gap-2 mt-4 pt-3 border-top">
                        <span class="fw-bold text-dark me-2" style="font-size: 0.9rem;"><i class="bi bi-tags me-1"></i> Tags:</span>
                        @foreach($blog->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                               class="badge text-decoration-none"
                               style="background:#EDF6FB; color:var(--kkt-primary); font-size:0.8rem; font-weight:600; padding:6px 14px; border-radius:14px;">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
                </div>
            {{-- Right Sidebar Column --}}
            <div class="col-lg-4">
                <aside class="sidebar-wrapper">

                    {{-- Widget 1: Blog Categories --}}
                    <div class="sidebar-luxury-card">
                        <div class="sidebar-header">
                            <h4 class="sidebar-title">Blog Categories</h4>
                            <a href="{{ route('blog.index') }}" class="sidebar-viewall-link">
                                View All <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <div class="sidebar-category-list">
                            @if(isset($categories) && $categories->count())
                                @foreach($categories as $category)
                                    @php
                                        $iconClass = $catIcons[$category->slug] ?? 'bi-folder2';
                                        $isActive  = ($catSlug && $catSlug === $category->slug);
                                    @endphp
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                       class="sidebar-cat-row {{ $isActive ? 'active' : '' }}">
                                        <div class="sidebar-cat-left">
                                            <i class="bi {{ $iconClass }} sidebar-cat-icon"></i>
                                            <span class="sidebar-cat-name">{{ $category->name }}</span>
                                        </div>
                                        <div class="sidebar-cat-right">
                                            <span class="sidebar-cat-badge">{{ $category->blogs_count ?? 0 }}</span>
                                            <i class="bi bi-chevron-right sidebar-cat-chevron"></i>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                {{-- Fallback Category Items Matching Mockup --}}
                                @php
                                    $fallbackCats = [
                                        ['name' => 'Home Decor', 'count' => 12, 'icon' => 'bi-house-door', 'slug' => 'home-decor'],
                                        ['name' => 'Tableware', 'count' => 8, 'icon' => 'bi-cup', 'slug' => 'tableware'],
                                        ['name' => 'Gifting Ideas', 'count' => 15, 'icon' => 'bi-gift', 'slug' => 'gifting-ideas'],
                                        ['name' => 'Interior Trends', 'count' => 10, 'icon' => 'bi-lamp', 'slug' => 'interior-trends'],
                                        ['name' => 'Lifestyle', 'count' => 7, 'icon' => 'bi-feather', 'slug' => 'lifestyle'],
                                        ['name' => 'Tips & Guides', 'count' => 9, 'icon' => 'bi-journal-text', 'slug' => 'tips-guides'],
                                        ['name' => 'Product Updates', 'count' => 6, 'icon' => 'bi-tag', 'slug' => 'product-updates'],
                                    ];
                                @endphp
                                @foreach($fallbackCats as $fCat)
                                    <a href="{{ route('blog.index', ['category' => $fCat['slug']]) }}" class="sidebar-cat-row">
                                        <div class="sidebar-cat-left">
                                            <i class="bi {{ $fCat['icon'] }} sidebar-cat-icon"></i>
                                            <span class="sidebar-cat-name">{{ $fCat['name'] }}</span>
                                        </div>
                                        <div class="sidebar-cat-right">
                                            <span class="sidebar-cat-badge">{{ $fCat['count'] }}</span>
                                            <i class="bi bi-chevron-right sidebar-cat-chevron"></i>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Widget 2: Latest Blogs --}}
                    <div class="sidebar-luxury-card">
                        <div class="sidebar-header">
                            <h4 class="sidebar-title">Latest Blogs</h4>
                            <a href="{{ route('blog.index') }}" class="sidebar-viewall-link">
                                View All <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <div class="sidebar-latest-list">
                            @php
                                $sidebarPosts = (isset($latestBlogs) && $latestBlogs->count())
                                    ? $latestBlogs
                                    : ((isset($related) && $related->count()) ? $related : collect([]));
                            @endphp

                            @if($sidebarPosts->count())
                                @foreach($sidebarPosts as $post)
                                    <a href="{{ route('blog.show', $post->slug) }}" class="sidebar-post-item">
                                        <img src="{{ $post->thumbnail_url }}"
                                             alt="{{ $post->title }}"
                                             class="sidebar-post-thumb"
                                             loading="lazy"
                                             onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                        <div class="sidebar-post-info">
                                            <h5 class="sidebar-post-title" title="{{ $post->title }}">
                                                {{ Str::limit($post->title, 50) }}
                                            </h5>
                                            <div class="sidebar-post-meta">
                                                <span><i class="bi bi-calendar3"></i> {{ $post->published_at?->format('M d, Y') ?? date('M d, Y') }}</span>
                                                <span><i class="bi bi-eye"></i> {{ number_format(max(1, $post->views)) }} views</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-muted small mb-0">No other articles available.</p>
                            @endif
                        </div>
                    </div>

                </aside>
            </div>

        </div>

    </div>
</section>

@push('scripts')
<script>
    function copyBlogLink(button) {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check2 text-success"></i>';
            if (typeof showToast === 'function') {
                showToast('Article link copied to clipboard!', 'success');
            }
            setTimeout(function() {
                button.innerHTML = originalHtml;
            }, 2000);
        }).catch(function() {
            if (typeof showToast === 'function') {
                showToast('Failed to copy link', 'danger');
            }
        });
    }
</script>
@endpush
@endsection
