<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
    <url><loc>{{ url('/shop') }}</loc><changefreq>daily</changefreq><priority>0.9</priority></url>
    @foreach($categories as $cat)
    <url><loc>{{ route('shop.category', $cat->slug) }}</loc><lastmod>{{ $cat->updated_at->toAtomString() }}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>
    @endforeach
    @foreach($products as $product)
    <url><loc>{{ route('product.show', $product->slug) }}</loc><lastmod>{{ $product->updated_at->toAtomString() }}</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>
    @endforeach
    @foreach($blogs as $blog)
    <url><loc>{{ route('blog.show', $blog->slug) }}</loc><lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.5</priority></url>
    @endforeach
</urlset>
