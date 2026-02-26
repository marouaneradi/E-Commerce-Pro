@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Shopping Cart</span>
        </div>
        <h1>🛒 Shopping Cart</h1>
        <p>{{ count($cartItems) }} item(s) in your cart</p>
    </div>
</div>

<div class="container">
    @if(empty($cartItems))
        <div class="empty-state card" style="max-width:500px;margin:2rem auto;">
            <div class="card-body">
                <div class="empty-state-icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some products to get started!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    @else
        <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start;">
            {{-- Cart Items --}}
            <div class="card">
                <div class="card-header">
                    <h3>Cart Items</h3>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm" data-confirm="Clear all items from cart?">🗑️ Clear Cart</button>
                    </form>
                </div>
                <div style="overflow-x:auto;">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $productId => $item)
                            <tr>
                                <td>
                                    <div class="cart-product-info">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="cart-product-img">
                                        @else
                                            <div class="cart-product-img" style="display:flex;align-items:center;justify-content:center;font-size:1.5rem;background:var(--bg);">📦</div>
                                        @endif
                                        <div>
                                            <a href="{{ route('products.show', $item['slug']) }}" class="cart-product-name">{{ $item['name'] }}</a>
                                            <div class="cart-product-price">${{ number_format($item['price'], 2) }} each</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="99" class="cart-qty-input">
                                    </form>
                                </td>
                                <td><strong>${{ number_format($item['total'], 2) }}</strong></td>
                                <td>
                                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon btn-sm" title="Remove">✕</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="display:flex;justify-content:space-between;align-items:center;">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">← Continue Shopping</a>
                    <span style="color:var(--text-muted);font-size:.875rem;">Change quantity to 0 to remove item</span>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="cart-summary">
                <div class="cart-summary-title">Order Summary</div>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Tax (8%)</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>
                        @if($shipping == 0)
                            <span class="free">FREE</span>
                        @else
                            ${{ number_format($shipping, 2) }}
                        @endif
                    </span>
                </div>
                @if($shipping > 0)
                <div style="font-size:.8rem;color:var(--text-muted);padding:.25rem 0;">
                    💡 Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping!
                </div>
                @endif
                <div class="summary-row total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block btn-lg" style="margin-top:1.25rem;">
                    Proceed to Checkout →
                </a>
                <div style="text-align:center;margin-top:1rem;font-size:.8rem;color:var(--text-muted);">
                    🔒 Secure checkout guaranteed
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
