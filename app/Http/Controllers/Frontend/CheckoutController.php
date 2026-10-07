<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
        private PaymentService $paymentService
    ) {}

    public function index()
    {
        $items = $this->cartService->getItems();
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Your cart is empty.');

        $totals    = $this->cartService->totals(session('coupon_code'));
        $addresses = Auth::user()->addresses;

        return view('frontend.checkout.index', compact('items', 'totals', 'addresses'));
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'shipping_name'          => 'required|string|max:100',
            'shipping_phone'         => 'required|string|max:15',
            'shipping_address_line1' => 'required|string|max:200',
            'shipping_address_line2' => 'nullable|string|max:200',
            'shipping_city'          => 'required|string|max:100',
            'shipping_state'         => 'required|string|max:100',
            'shipping_pincode'       => 'required|string|max:10',
            'payment_method'         => 'required|in:razorpay,cod',
            'notes'                  => 'nullable|string|max:500',
        ]);

        $items = $this->cartService->getItems();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $order = $this->orderService->createFromCart(array_merge(
            $data,
            [
                'user_id' => Auth::id(),
                'coupon_code' => session('coupon_code')
            ]
        ));

        session()->forget('coupon_code');

        if ($request->payment_method === 'razorpay') {
            $rpData = $this->paymentService->createRazorpayOrder($order);
            return view('frontend.checkout.razorpay', compact('order', 'rpData'));
        }
            // Fire the event immediately for COD orders
            event(new \App\Events\OrderPlaced($order));

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Order placed successfully!');
    }

    public function razorpayCallback(Request $request)
    {
        $success = $this->paymentService->verifyAndCapture($request->all());

        if ($success) {
            $orderNumber = \App\Models\Payment::where('razorpay_order_id', $request->razorpay_order_id)
                ->first()?->order?->order_number;
            return redirect()->route('checkout.success', $orderNumber)
                ->with('success', 'Payment successful!');
        }

        return redirect()->route('checkout.failure')->with('error', 'Payment verification failed.');
    }

    public function success(string $orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }

    public function failure()
    {
        return view('frontend.checkout.failure');
    }
}
