<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();
        $featuredCategories = Category::active()->featured()->with('subcategories')->orderBy('sort_order')->take(16)->get();
        if ($featuredCategories->count() < 8) {
            $allActive = Category::active()->with('subcategories')->orderBy('sort_order')->take(16)->get();
            if ($allActive->count() > $featuredCategories->count()) {
                $featuredCategories = $allActive;
            }
        }
        $featuredProducts = Product::active()->featured()->with(['images', 'category'])->take(8)->get();
        $trendingProducts = Product::active()->trending()->with(['images', 'category'])->take(8)->get();
        $newArrivals      = Product::active()->newArrivals()->with(['images', 'category'])->take(8)->get();
        $bestSellers      = Product::active()->bestSellers()->with(['images', 'category'])->take(8)->get();
        $saleProducts     = Product::active()->onSale()->with(['images', 'category'])->take(8)->get();
        $testimonials     = Testimonial::active()->take(6)->get();
        $latestBlogs      = Blog::published()->latest('published_at')->take(3)->get();

        // dd($latestBlogs);
        // exit;



        return view('frontend.home.index', compact(
            'banners', 'featuredCategories', 'featuredProducts',
            'trendingProducts', 'newArrivals', 'bestSellers',
            'saleProducts', 'testimonials', 'latestBlogs'
        ));
    }
}
