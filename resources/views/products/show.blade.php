@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('products.index') }}">Shop</a>
        <span class="breadcrumb-sep">›</span>
        @if($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            <span class="breadcrumb-sep">›</span>
        @endif
        <span class="breadcrumb-current">{{ $product->name }}</span>
    </div>

    <div class="product-detail-grid">
        {{-- Gallery --}}
        <div class="product-gallery">
            <div class="product-main-image">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainImage">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg);color:var(--text-muted);font-size:4rem;">📦</div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div>
            @if($product->category)
                <div class="product-category" style="margin-bottom:.5rem;">{{ $product->category->name }}</div>
            @endif

            <h1 class="product-detail-name">{{ $product->name }}</h1>

            @if($product->sku)
                <p style="font-size:.8rem;color:var(--text-muted);margin-bottom:.75rem;">SKU: {{ $product->sku }}</p>
            @endif

            {{-- Rating --}}
            @if($product->reviews_count > 0)
            <div class="product-rating" style="margin-bottom:1rem;">
                <span class="stars" style="font-size:1.1rem;">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= round($product->average_rating) ? '★' : '☆' }}
                    @endfor
                </span>
                <span style="font-weight:600;">{{ number_format($product->average_rating, 1) }}</span>
                <span class="rating-count">({{ $product->reviews_count }} reviews)</span>
            </div>
            @endif

            {{-- Price --}}
            <div class="product-detail-price">
                <span class="price-current">${{ number_format($product->price, 2) }}</span>
                @if($product->compare_price)
                    <span class="price-compare">${{ number_format($product->compare_price, 2) }}</span>
                    @if($product->discount_percentage)
                        <span class="price-discount">Save {{ $product->discount_percentage }}%</span>
                    @endif
                @endif
            </div>

            {{-- Stock --}}
            @if($product->isInStock())
                <span class="stock-badge stock-in">✓ In Stock ({{ $product->stock }} available)</span>
            @else
                <span class="stock-badge stock-out">✗ Out of Stock</span>
            @endif

            {{-- Description --}}
            @if($product->short_description)
                <p class="product-detail-desc">{{ $product->short_description }}</p>
            @endif

            {{-- Add to Cart --}}
            @if($product->isInStock())
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div style="margin-bottom:1.5rem;">
                    <label class="form-label">Quantity</label>
                    <div class="qty-selector">
                        <button type="button" class="qty-btn" data-action="decrease">−</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                        <button type="button" class="qty-btn" data-action="increase">+</button>
                    </div>
                </div>

                <div class="add-to-cart-btn">
                    <button type="submit" class="btn btn-primary btn-lg">🛒 Add to Cart</button>
                    <a href="{{ route('checkout.index') }}" class="btn btn-secondary btn-lg">⚡ Buy Now</a>
                </div>
            </form>
            @else
                <div class="alert alert-error">This product is currently out of stock.</div>
            @endif

            {{-- Info tabs --}}
            <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border);">
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:1rem;">Product Description</h3>
                <div style="color:var(--text-secondary);line-height:1.75;font-size:.95rem;">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>
    </div>

    {{-- Reviews --}}
    <section style="margin:3rem 0;padding-top:2rem;border-top:2px solid var(--border);">
        <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start;">
            <div>
                <h2 style="font-size:1.375rem;font-weight:800;margin-bottom:1.5rem;">
                    Customer Reviews
                    @if($product->reviews_count > 0)
                        <span style="font-size:.875rem;color:var(--text-muted);font-weight:500;">({{ $product->reviews_count }})</span>
                    @endif
                </h2>

                @if($product->approvedReviews->isEmpty())
                    <div class="empty-state" style="padding:2rem;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-md);">
                        <div class="empty-state-icon">💬</div>
                        <p>No reviews yet. Be the first to review!</p>
                    </div>
                @else
                    <div class="reviews-list">
                        @foreach($product->approvedReviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="{{ $review->user->avatar_url }}" class="reviewer-avatar" alt="{{ $review->user->name }}">
                                    <div>
                                        <div class="reviewer-name">{{ $review->user->name }}</div>
                                        <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                                </div>
                            </div>
                            @if($review->title)
                                <div class="review-title">{{ $review->title }}</div>
                            @endif
                            @if($review->body)
                                <div class="review-body">{{ $review->body }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Write Review --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <h3>Write a Review</h3>
                    </div>
                    <div class="card-body">
                        @auth
                            @if($userReview)
                                <div class="alert alert-info">You've already reviewed this product.</div>
                            @endif
                            <form action="{{ route('products.review', $product) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Your Rating <span class="required">*</span></label>
                                    <div class="star-rating" style="display:flex;gap:.25rem;flex-direction:row-reverse;justify-content:flex-end;">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}>
                                            <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
                                        @endfor
                                    </div>
                                    @error('rating')<div class="form-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Review Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Summarize your review" value="{{ old('title', $userReview?->title) }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Review</label>
                                    <textarea name="body" class="form-control" placeholder="Tell others about your experience..." rows="4">{{ old('body', $userReview?->body) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ $userReview ? '✏️ Update Review' : '📝 Submit Review' }}
                                </button>
                            </form>
                        @else
                            <p style="color:var(--text-secondary);font-size:.9rem;text-align:center;margin-bottom:1rem;">Please login to write a review</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login to Review</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
    <section style="margin:2rem 0 3rem;">
        <h2 style="font-size:1.375rem;font-weight:800;margin-bottom:1.5rem;">Related Products</h2>
        <div class="products-grid">
            @foreach($relatedProducts as $related)
                @include('partials.product-card', ['product' => $related])
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
