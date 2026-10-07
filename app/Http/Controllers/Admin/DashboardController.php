<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Revenue stats
        $todayRevenue   = Order::whereDate('created_at', today())->where('payment_status','paid')->sum('total');
        $monthRevenue   = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('payment_status','paid')->sum('total');
        $totalRevenue   = Order::where('payment_status','paid')->sum('total');

        // Order stats
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status','pending')->count();
        $processingOrders = Order::whereIn('status',['confirmed','processing','shipped','out_for_delivery'])->count();
        $deliveredOrders = Order::where('status','delivered')->count();

        // Customer stats
        $totalCustomers = User::count();
        $newCustomers   = User::whereMonth('created_at', now()->month)->count();

        // Product stats
        $totalProducts  = Product::count();
        $lowStockProducts = Product::where('manage_stock', true)
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0)
            ->count();
        $outOfStock     = Product::where('manage_stock', true)->where('stock', 0)->count();

        // Recent orders
        $recentOrders   = Order::with('user')->latest()->take(10)->get();

        // Monthly revenue chart (last 12 months)
        $monthlyRevenue = Order::where('payment_status','paid')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();

        // Top products
        $topProducts = DB::table('order_items')
            ->join('products','products.id','=','order_items.product_id')
            ->select('products.id','products.name','products.thumbnail',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as revenue'))
            ->groupBy('products.id','products.name','products.thumbnail')
            ->orderByDesc('total_sold')
            ->take(5)->get();

         



        return view('admin.dashboard.index', compact(
            'todayRevenue','monthRevenue','totalRevenue',
            'totalOrders','pendingOrders','processingOrders','deliveredOrders',
            'totalCustomers','newCustomers',
            'totalProducts','lowStockProducts','outOfStock',
            'recentOrders','monthlyRevenue','topProducts'
        ));
    }
}
