<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login first.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'  => 'nullable|string|max:255',
            'body'   => 'required|string|max:1000',
        ]);

        // Check existing review
        $alreadyReviewed = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You already reviewed this product.');
        }

        Review::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'title'      => $request->title,
            'body'       => $request->body,
            'status'     => 'approved',
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }
}