@extends('layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('user.dashboard') }}">Dashboard</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('user.orders') }}">Orders</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">{{ $order->order_number }}</span>
        </div>
        <h1>Order Details</h1>
    </div>
</div>

<div class="container" style="max-width:900px;">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>{{ $order->order_number }}</h3>
                <p style="color:var(--text-muted);font-size:.875rem;margin-top:.25rem;">Placed {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
            <span class="status-badge status-{{ $order->status }}" style="font-size:.875rem;padding:.375rem 1rem;">{{ ucfirst($order->status) }}</span>
        </div>

        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.5rem;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border);">
                <div>
                    <h4 style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.5rem;">Ship To</h4>
                    <p style="font-weight:600;">{{ $order->full_name }}</p>
                    <p style="font-size:.875rem;color:var(--text-secondary);">{{ $order->address }}</p>
                    <p style="font-size:.875rem;color:var(--text-secondary);">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                </div>
                <div>
                    <h4 style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.5rem;">Contact</h4>
                    <p style="font-size:.875rem;color:var(--text-secondary);">{{ $order->email }}</p>
                    @if($order->phone)<p style="font-size:.875rem;color:var(--text-secondary);">{{ $order->phone }}</p>@endif
                </div>
                <div>
                    <h4 style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.5rem;">Payment</h4>
                    <p style="font-size:.875rem;">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>

            {{-- Items --}}
            <h4 style="font-weight:700;margin-bottom:1rem;">Ordered Items</h4>
            @foreach($order->items as $item)
            <div style="display:flex;align-items:center;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--border);">
                @if($item->product_image)
                    <img src="{{ asset('storage/' . $item->product_image) }}" style="width:56px;height:56px;border-radius:var(--radius);object-fit:cover;border:1px solid var(--border);" alt="">
                @else
                    <div style="width:56px;height:56px;border-radius:var(--radius);background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:1.5rem;border:1px solid var(--border);">📦</div>
                @endif
                <div style="flex:1;">
                    <div style="font-weight:600;">{{ $item->product_name }}</div>
                    <div style="font-size:.875rem;color:var(--text-muted);">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                </div>
                <div style="font-weight:700;font-size:1rem;">${{ number_format($item->total, 2) }}</div>
            </div>
            @endforeach

            {{-- Summary --}}
            <div style="max-width:280px;margin-left:auto;margin-top:1.5rem;">
                <div class="summary-row"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="summary-row"><span>Tax</span><span>${{ number_format($order->tax, 2) }}</span></div>
                <div class="summary-row"><span>Shipping</span><span>@if($order->shipping == 0)<span style="color:var(--accent);">FREE</span>@else${{ number_format($order->shipping, 2) }}@endif</span></div>
                <div class="summary-row total"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
            </div>

            @if($order->notes)
            <div style="margin-top:1.5rem;padding:1rem;background:var(--bg);border-radius:var(--radius);border:1px solid var(--border);">
                <strong style="font-size:.875rem;">Order Notes:</strong>
                <p style="font-size:.875rem;color:var(--text-secondary);margin-top:.25rem;">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <div class="card-footer" style="display:flex;justify-content:space-between;">
            <a href="{{ route('user.orders') }}" class="btn btn-ghost">← Back to Orders</a>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
