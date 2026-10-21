<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['category', 'images']);

        $this->applyFilters($query, $request);

        $products   = $query->paginate(16)->withQueryString();
        $categories = Category::active()->withCount(['products' => fn($q) => $q->active()])->get();

        return view('frontend.products.listing', compact('products', 'categories'));
    }

    public function category(Request $request, $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $query    = Product::active()
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['category', 'images']);

        $this->applyFilters($query, $request);

        $products   = $query->paginate(16)->withQueryString();
        $categories = Category::active()->withCount(['products' => fn($q) => $q->active()])->get();

        return view('frontend.products.category', compact('products', 'category', 'categories'));
    }


    public function subcategory(Request $request, $categorySlug, $subcategorySlug)
    {
        return redirect()->route('shop.category', $categorySlug);
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->with(['category', 'subcategory', 'categories', 'subcategories', 'images', 'variants', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $product->increment('views');

        // Recently viewed
        $recent = session('recently_viewed', []);
        $recent = array_filter($recent, fn($id) => $id !== $product->id);
        array_unshift($recent, $product->id);
        session(['recently_viewed' => array_slice($recent, 0, 10)]);

        $relatedCategoryIds = $product->categories->pluck('id')
            ->push($product->category_id)
            ->filter()
            ->unique();

        $related = Product::active()
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $relatedCategoryIds))
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(8)->get();

        $recentlyViewed = Product::active()
            ->whereIn('id', array_slice($recent, 1, 5))
            ->with('images')->get();

        return view('frontend.products.show', compact('product', 'related', 'recentlyViewed'));
    }

    public function search(Request $request)
    {
        return redirect()->route('shop', $request->query());
    }

    public function ajaxSearch(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) return response()->json([]);

        $terms = array_filter(explode(' ', $q), fn($t) => strlen($t) > 0);

        $products = Product::active()
            ->where(function ($subQ) use ($q, $terms) {
                $subQ->where('name', 'like', '%' . $q . '%')
                     ->orWhere('sku', 'like', '%' . $q . '%')
                     ->orWhere('short_description', 'like', '%' . $q . '%')
                     ->orWhere('description', 'like', '%' . $q . '%')
                     ->orWhere('meta_keywords', 'like', '%' . $q . '%')
                     ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $q . '%'))
                     ->orWhereHas('categories', fn($c) => $c->where('categories.name', 'like', '%' . $q . '%'));

                if (count($terms) > 1) {
                    $subQ->orWhere(function ($allTermsQ) use ($terms) {
                        foreach ($terms as $term) {
                            $allTermsQ->where(function ($termQ) use ($term) {
                                $termQ->where('name', 'like', '%' . $term . '%')
                                      ->orWhere('sku', 'like', '%' . $term . '%')
                                      ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $term . '%'))
                                      ->orWhereHas('categories', fn($c) => $c->where('categories.name', 'like', '%' . $term . '%'));
                            });
                        }
                    });
                }
            })
            ->with(['category', 'images'])
            ->take(8)->get()
            ->map(fn($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'category' => $p->category?->name,
                'price'    => $p->effective_price,
                'image'    => $p->thumbnail_url,
                'url'      => route('product.show', $p->slug),
            ]);

        return response()->json($products);
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('q')) {
            $searchTerm = trim($request->input('q'));
            if ($searchTerm !== '') {
                $terms = array_filter(explode(' ', $searchTerm), fn($t) => strlen($t) > 0);
                $query->where(function ($subQ) use ($searchTerm, $terms) {
                    $subQ->where('name', 'like', '%' . $searchTerm . '%')
                         ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                         ->orWhere('short_description', 'like', '%' . $searchTerm . '%')
                         ->orWhere('description', 'like', '%' . $searchTerm . '%')
                         ->orWhere('meta_keywords', 'like', '%' . $searchTerm . '%')
                         ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $searchTerm . '%'))
                         ->orWhereHas('categories', fn($c) => $c->where('categories.name', 'like', '%' . $searchTerm . '%'))
                         ->orWhereHas('variants', fn($v) => $v->where('sku', 'like', '%' . $searchTerm . '%')->orWhere('size', 'like', '%' . $searchTerm . '%')->orWhere('color', 'like', '%' . $searchTerm . '%'));

                    if (count($terms) > 1) {
                        $subQ->orWhere(function ($allTermsQ) use ($terms) {
                            foreach ($terms as $term) {
                                $allTermsQ->where(function ($termQ) use ($term) {
                                    $termQ->where('name', 'like', '%' . $term . '%')
                                          ->orWhere('sku', 'like', '%' . $term . '%')
                                          ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $term . '%'))
                                          ->orWhereHas('categories', fn($c) => $c->where('categories.name', 'like', '%' . $term . '%'));
                                });
                            }
                        });
                    }
                });
            }
        }

        $effectivePriceSql = 'CASE WHEN sale_price IS NOT NULL AND sale_price > 0 AND sale_price < price THEN sale_price ELSE price END';

        if ($request->filled('min_price')) {
            $minPrice = (float) $request->min_price;
            $query->whereRaw("({$effectivePriceSql}) >= ?", [$minPrice]);
        }
        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->max_price;
            $query->whereRaw("({$effectivePriceSql}) <= ?", [$maxPrice]);
        }
        if ($request->boolean('in_stock')) {
            $query->where(fn($q) => $q->where('manage_stock', false)
                ->orWhere('stock', '>', 0));
        }
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_price')->whereRaw('sale_price > 0 AND sale_price < price');
        }

        $isPriceFiltered = $request->filled('min_price') || $request->filled('max_price');
        $sort = $request->input('sort');

        // When filtering in price range, default to ascending order unless another explicit sort is specified
        if ($isPriceFiltered && (!$sort || $sort === 'latest')) {
            $sort = 'price_asc';
        } elseif (!$sort) {
            $sort = 'latest';
        }

        match ($sort) {
            'price_asc'  => $query->orderByRaw("{$effectivePriceSql} ASC"),
            'price_desc' => $query->orderByRaw("{$effectivePriceSql} DESC"),
            'popular'    => $query->orderByDesc('views'),
            default      => $query->latest(),
        };
    }
}
