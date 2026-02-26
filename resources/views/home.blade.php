@extends('layouts.app')

@section('title', 'Home - Premium Shopping')

@section('content')

{{-- Hero Section --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">✨ New Collection Available</div>
            <h1>Shop the <span>Best Products</span> Online</h1>
            <p>Discover thousands of premium products with unbeatable prices, fast shipping, and exceptional quality.</p>
            <div class="hero-actions">
                <a href="{{ route('products.index') }}" class="btn btn-white btn-lg">🛍️ Shop Now</a>
                <a href="{{ route('products.index', ['sort' => 'rating']) }}" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.5);color:white;">⭐ Top Rated</a>
            </div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-8">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Shop by <span>Category</span></h2>
                <p class="section-subtitle">Find exactly what you're looking for</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">View All →</a>
        </div>

        <div class="categories-grid">
            @php
            $icons = ['Electronics' => '📱', 'Clothing' => '👕', 'Books' => '📚', 'Home & Garden' => '🏠', 'Sports' => '⚽', 'Beauty' => '💄', 'Toys' => '🧸', 'Food' => '🍕', 'Automotive' => '🚗', 'Health' => '💊'];
            @endphp
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
                <div class="category-icon">
                    {{ $icons[$category->name] ?? '🏷️' }}
                </div>
                <span class="category-name">{{ $category->name }}</span>
                <span class="category-count">{{ $category->active_products_count ?? 0 }} Products</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="py-8" style="background:var(--bg-card);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">⭐ Featured <span>Products</span></h2>
                <p class="section-subtitle">Handpicked products just for you</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'rating']) }}" class="btn btn-outline btn-sm">See All →</a>
        </div>

        <div class="products-grid">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

{{-- Latest Products --}}
<section class="py-8">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">🆕 New <span>Arrivals</span></h2>
                <p class="section-subtitle">Fresh products added this week</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">View All →</a>
        </div>

        <div class="products-grid">
            @foreach($latestProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

{{-- Value Propositions --}}
<section class="py-8" style="background:linear-gradient(135deg,#1e1b4b,#312e81);color:white;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2rem;text-align:center;">
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🚀</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Fast Delivery</h3>
                <p style="opacity:.75;font-size:.875rem;">Free shipping on orders over $100</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🔒</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Secure Payment</h3>
                <p style="opacity:.75;font-size:.875rem;">100% secure transactions</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">↩️</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Easy Returns</h3>
                <p style="opacity:.75;font-size:.875rem;">30 day return policy</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">💬</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">24/7 Support</h3>
                <p style="opacity:.75;font-size:.875rem;">Always here to help you</p>
            </div>
        </div>
    </div>
</section>

@endsection
