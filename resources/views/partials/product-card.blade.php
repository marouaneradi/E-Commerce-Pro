@php
    $discount = $product->discount_percentage;
@endphp

<div class="product-card">
    <a href="{{ route('products.show', $product->slug) }}" class="product-image-wrap">
        @if($product->image)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @else
            <div class="product-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
            </div>
        @endif

        @if($product->is_featured)
            <span class="product-badge badge-featured">⭐ Featured</span>
        @elseif($discount)
            <span class="product-badge badge-sale">-{{ $discount }}%</span>
        @elseif($product->created_at->isAfter(now()->subDays(7)))
            <span class="product-badge badge-new">New</span>
        @endif

        @if(!$product->isInStock())
            <span class="product-badge badge-out" style="top:auto;bottom:.75rem;left:.75rem;">Out of Stock</span>
        @endif
    </a>

    <div class="product-info">
        <div class="product-category">{{ $product->category->name ?? '' }}</div>
        <a href="{{ route('products.show', $product->slug) }}" class="product-name">{{ $product->name }}</a>

        @if($product->reviews_count > 0)
        <div class="product-rating">
            <span class="stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($product->average_rating) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="rating-count">({{ $product->reviews_count }})</span>
        </div>
        @endif

        <div class="product-price-row">
            <span class="price-current">${{ number_format($product->price, 2) }}</span>
            @if($product->compare_price)
                <span class="price-compare">${{ number_format($product->compare_price, 2) }}</span>
                @if($discount)
                    <span class="price-discount">Save {{ $discount }}%</span>
                @endif
            @endif
        </div>
    </div>

    <div class="product-card-footer">
        @if($product->isInStock())
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary btn-sm" style="width:100%">🛒 Add to Cart</button>
            </form>
        @else
            <button class="btn btn-ghost btn-sm" style="width:100%" disabled>Out of Stock</button>
        @endif
        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline btn-sm btn-icon" title="View Details">👁️</a>
    </div>
</div>
