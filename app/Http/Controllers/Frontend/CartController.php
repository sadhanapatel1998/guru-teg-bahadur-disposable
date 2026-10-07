<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        $items  = $this->cartService->getItems();
        $totals = $this->cartService->totals(session('coupon_code'));
        return view('frontend.cart.index', compact('items', 'totals'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id'         => 'required|exists:products,id',
            'quantity'           => 'integer|min:1|max:50',
            'product_variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $this->cartService->add(
            $request->product_id,
            $request->input('quantity', 1),
            $request->product_variant_id
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'count'   => $this->cartService->count(),
            ]);
        }

        return back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request, int $cartId)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:50']);
        $this->cartService->update($cartId, $request->quantity);

        $totals = $this->cartService->totals(session('coupon_code'));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'totals' => $totals]);
        }

        return back();
    }

    public function remove(int $cartId)
    {
        $this->cartService->remove($cartId);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'count'   => $this->cartService->count(),
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $code   = strtoupper($request->coupon_code);
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
            }
            return back()->with('error', 'Invalid or expired coupon.');
        }

        $subtotal = $this->cartService->getItems()->sum(fn($i) => $i->line_total);
        if ($subtotal < $coupon->min_order_amount) {
            $msg = 'Minimum order amount ₹' . number_format($coupon->min_order_amount, 2) . ' required.';
            if ($request->ajax()) return response()->json(['success' => false, 'message' => $msg]);
            return back()->with('error', $msg);
        }

        session(['coupon_code' => $code]);
        $totals = $this->cartService->totals($code);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Coupon applied! You saved ₹' . number_format($totals['discount'], 2),
                'totals'   => $totals,
            ]);
        }

        return back()->with('success', 'Coupon applied!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');
        return back()->with('success', 'Coupon removed.');
    }
}
