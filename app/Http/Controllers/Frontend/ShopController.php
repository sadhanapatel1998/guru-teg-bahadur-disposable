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

        $products      = $query->paginate(16)->withQueryString();
        $subcategories = $category->subcategories;
        $categories = Category::active()->withCount(['products' => fn($q) => $q->active()])->get();

        return view('frontend.products.category', compact('products', 'category', 'subcategories','categories'));
    }


    public function subcategory(Request $request, $categorySlug, $subcategorySlug)
    {
        $category    = Category::where('slug', $categorySlug)->firstOrFail();
        $subcategory = Subcategory::where('slug', $subcategorySlug)
            ->where('category_id', $category->id)->firstOrFail();

        $query = Product::active()
            ->whereHas('subcategories', fn($q) => $q->where('subcategories.id', $subcategory->id))
            ->with(['category', 'images']);

        $this->applyFilters($query, $request);

        $products = $query->paginate(16)->withQueryString();
        $categories = Category::active()->withCount(['products' => fn($q) => $q->active()])->get();

        return view('frontend.products.subcategory', compact('products', 'category', 'subcategory','categories'));
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
        $query    = $request->input('q', '');
        $products = collect();

        if (strlen($query) >= 2) {
            $q = Product::active()->with(['category', 'images']);
            $q->where(function ($qr) use ($query) {
                $qr->where('name', 'like', '%' . $query . '%')
                   ->orWhere('sku', 'like', '%' . $query . '%')
                   ->orWhere('short_description', 'like', '%' . $query . '%')
                   ->orWhereHas('category', fn($c) => $c->where('name', 'like', '%' . $query . '%'));
            });
            $this->applyFilters($q, $request);
            $products = $q->paginate(16)->withQueryString();
        }

        return view('frontend.search.results', compact('products', 'query'));
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->input('q', '');
        if (strlen($q) < 2) return response()->json([]);

        $products = Product::active()
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%')
                      ->orWhere('sku', 'like', '%' . $q . '%');
            })
            ->with('images')
            ->take(8)->get()
            ->map(fn($p) => [
                'id'    => $p->id,
                'name'  => $p->name,
                'price' => $p->effective_price,
                'image' => $p->thumbnail_url,
                'url'   => route('product.show', $p->slug),
            ]);

        return response()->json($products);
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('min_price')) {
            $query->where(fn($q) => $q->where('sale_price', '>=', $request->min_price)
                ->orWhere(fn($q2) => $q2->whereNull('sale_price')->where('price', '>=', $request->min_price)));
        }
        if ($request->filled('max_price')) {
            $query->where(fn($q) => $q->where('sale_price', '<=', $request->max_price)
                ->orWhere(fn($q2) => $q2->whereNull('sale_price')->where('price', '<=', $request->max_price)));
        }
        if ($request->boolean('in_stock')) {
            $query->where(fn($q) => $q->where('manage_stock', false)
                ->orWhere('stock', '>', 0));
        }
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_price');
        }

        match ($request->input('sort', 'latest')) {
            'price_asc'  => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'popular'    => $query->orderByDesc('views'),
            default      => $query->latest(),
        };
    }
}
