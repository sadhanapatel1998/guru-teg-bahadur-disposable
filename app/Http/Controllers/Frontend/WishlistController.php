<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::with('product.images')
            ->where('user_id', Auth::id())->get();
        return view('frontend.cart.wishlist', compact('items'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)->first();

        if ($exists) {
            $exists->delete();
            $inWishlist = false;
            $message    = 'Removed from wishlist.';
        } else {
            Wishlist::create(['user_id' => Auth::id(), 'product_id' => $request->product_id]);
            $inWishlist = true;
            $message    = 'Added to wishlist!';
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'inWishlist' => $inWishlist, 'message' => $message]);
        }
        return back()->with('success', $message);
    }
}
