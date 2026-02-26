@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="container">
    <div class="confirmation-card card">
        <div class="card-body" style="padding:3rem;text-align:center;">
            <div class="confirmation-icon">✅</div>
            <h1 style="font-size:2rem;font-weight:900;margin-bottom:.5rem;">Order Confirmed!</h1>
            <p style="color:var(--text-secondary);font-size:1.1rem;margin-bottom:.5rem;">
                Thank you, {{ $order->first_name }}! Your order has been placed.
            </p>
            <div style="display:inline-block;background:var(--bg);border:1.5px solid var(--border);border-radius:var(--radius);padding:.625rem 1.5rem;margin:1rem 0;">
                <span style="font-size:.875rem;color:var(--text-muted);">Order Number: </span>
                <strong style="color:var(--primary);">{{ $order->order_number }}</strong>
            </div>
            <p style="color:var(--text-muted);font-size:.875rem;">
                A confirmation email will be sent to <strong>{{ $order->email }}</strong>
            </p>
        </div>

        {{-- Order Details --}}
        <div style="border-top:1px solid var(--border);padding:2rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem;text-align:left;">
                <div>
                    <h3 style="font-weight:700;margin-bottom:.75rem;font-size:.875rem;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Shipping To</h3>
                    <p style="font-weight:600;">{{ $order->full_name }}</p>
                    <p style="color:var(--text-secondary);font-size:.9rem;">{{ $order->address }}</p>
                    <p style="color:var(--text-secondary);font-size:.9rem;">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                    <p style="color:var(--text-secondary);font-size:.9rem;">{{ $order->country }}</p>
                </div>
                <div>
                    <h3 style="font-weight:700;margin-bottom:.75rem;font-size:.875rem;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Order Info</h3>
                    <div style="display:flex;flex-direction:column;gap:.375rem;font-size:.9rem;">
                        <div class="flex justify-between"><span style="color:var(--text-muted);">Status:</span>
                            <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="flex justify-between"><span style="color:var(--text-muted);">Payment:</span><span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></div>
                        <div class="flex justify-between"><span style="color:var(--text-muted);">Date:</span><span>{{ $order->created_at->format('M d, Y') }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <h3 style="font-weight:700;margin-bottom:1rem;font-size:.875rem;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Items Ordered</h3>
            <table class="order-items" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        <th style="padding:.75rem 1rem;text-align:left;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Product</th>
                        <th style="padding:.75rem 1rem;text-align:center;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Qty</th>
                        <th style="padding:.75rem 1rem;text-align:right;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Price</th>
                        <th style="padding:.75rem 1rem;text-align:right;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr style="border-top:1px solid var(--border);">
                        <td style="padding:1rem;">
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                @if($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}" style="width:44px;height:44px;object-fit:cover;border-radius:var(--radius-sm);border:1px solid var(--border);" alt="">
                                @endif
                                <span style="font-weight:600;font-size:.9rem;">{{ $item->product_name }}</span>
                            </div>
                        </td>
                        <td style="padding:1rem;text-align:center;color:var(--text-secondary);">{{ $item->quantity }}</td>
                        <td style="padding:1rem;text-align:right;color:var(--text-secondary);">${{ number_format($item->price, 2) }}</td>
                        <td style="padding:1rem;text-align:right;font-weight:700;">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="padding:.75rem 1rem;text-align:right;color:var(--text-secondary);border-top:1px solid var(--border);font-size:.9rem;">Subtotal</td>
                        <td style="padding:.75rem 1rem;text-align:right;border-top:1px solid var(--border);">${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding:.375rem 1rem;text-align:right;color:var(--text-secondary);font-size:.9rem;">Tax</td>
                        <td style="padding:.375rem 1rem;text-align:right;">${{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding:.375rem 1rem;text-align:right;color:var(--text-secondary);font-size:.9rem;">Shipping</td>
                        <td style="padding:.375rem 1rem;text-align:right;">@if($order->shipping == 0)<span style="color:var(--accent);font-weight:600;">FREE</span>@else${{ number_format($order->shipping, 2) }}@endif</td>
                    </tr>
                    <tr style="border-top:2px solid var(--border);">
                        <td colspan="3" style="padding:1rem;text-align:right;font-weight:800;font-size:1.125rem;">Total</td>
                        <td style="padding:1rem;text-align:right;font-weight:900;font-size:1.25rem;color:var(--primary);">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card-footer" style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('user.orders') }}" class="btn btn-primary">📦 View My Orders</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline">🛍️ Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
