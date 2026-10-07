<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to', now()->toDateString());

        $orders = Order::where('payment_status', 'paid')
            ->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('SUM(discount_amount) as discounts')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totals = [
            'revenue'      => $orders->sum('revenue'),
            'order_count'  => $orders->sum('order_count'),
            'discounts'    => $orders->sum('discounts'),
            'avg_order'    => $orders->count() ? $orders->sum('revenue') / $orders->count() : 0,
        ];

        return view('admin.reports.sales', compact('orders', 'totals', 'from', 'to'));
    }

    public function inventory()
    {
        $products = Product::with('category')
            ->where('manage_stock', true)
            ->orderBy('stock', 'asc')
            ->paginate(30);

        $outOfStock  = Product::where('manage_stock', true)->where('stock', 0)->count();
        $lowStock    = Product::where('manage_stock', true)
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0)->count();

        return view('admin.reports.inventory', compact('products', 'outOfStock', 'lowStock'));
    }

    public function customers(Request $request)
    {
        $customers = User::withCount('orders')
            ->withSum(['orders' => fn($q) => $q->where('payment_status', 'paid')], 'total')
            ->orderByDesc('orders_sum_total')
            ->paginate(30);

        return view('admin.reports.customers', compact('customers'));
    }
}
