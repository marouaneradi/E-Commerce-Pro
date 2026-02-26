<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->withCount(['activeProducts'])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $latestProducts = Product::with('category')
            ->active()
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
