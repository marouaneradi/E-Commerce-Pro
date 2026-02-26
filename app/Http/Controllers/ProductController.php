<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'rating' => $query->orderBy('average_rating', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('activeProducts')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'approvedReviews.user'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $userReview = null;
        if (auth()->check()) {
            $userReview = ProductReview::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('products.show', compact('product', 'relatedProducts', 'userReview'));
    }

    public function review(Request $request, Product $product)
    {
        $this->middleware('auth');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:2000',
        ]);

        ProductReview::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->id()],
            [
                'rating' => $request->rating,
                'title' => $request->title,
                'body' => $request->body,
                'is_approved' => true,
            ]
        );

        return back()->with('success', 'Review submitted successfully!');
    }
}
