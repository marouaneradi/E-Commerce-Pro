<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'total_products' => Product::count(),
            'total_users' => User::where('is_admin', false)->count(),
            'total_categories' => Category::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', now()->year)
            ->whereNotIn('status', ['cancelled'])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month')
            ->toArray();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'topProducts', 'monthlyRevenue'));
    }
}
