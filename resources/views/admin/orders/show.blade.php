@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Order: {{ $order->order_number }}</h1>
        <p style="color:var(--text-muted);">Placed {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">← Back to Orders</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;">
    {{-- Order Details --}}
    <div>
        {{-- Items --}}
        <div class="admin-card" style="margin-bottom:1.5rem;">
            <div class="admin-card-header"><h3>Items Ordered</h3></div>
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem;">
                                    @if($item->product_image)
                                        <img src="{{ asset('storage/' . $item->product_image) }}" style="width:44px;height:44px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);" alt="">
                                    @else
                                        <div style="width:44px;height:44px;border-radius:var(--radius-sm);background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:1rem;border:1px solid var(--border);">📦</div>
                                    @endif
                                    {{ $item->product_name }}
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" style="text-align:right;color:var(--text-muted);padding:.75rem 1rem;border-top:1px solid var(--border);">Subtotal</td><td style="padding:.75rem 1rem;border-top:1px solid var(--border);">${{ number_format($order->subtotal, 2) }}</td></tr>
                        <tr><td colspan="3" style="text-align:right;color:var(--text-muted);padding:.5rem 1rem;">Tax</td><td style="padding:.5rem 1rem;">${{ number_format($order->tax, 2) }}</td></tr>
                        <tr><td colspan="3" style="text-align:right;color:var(--text-muted);padding:.5rem 1rem;">Shipping</td><td style="padding:.5rem 1rem;">@if($order->shipping == 0)<span style="color:var(--accent);">FREE</span>@else${{ number_format($order->shipping, 2) }}@endif</td></tr>
                        <tr><td colspan="3" style="text-align:right;font-weight:800;font-size:1rem;padding:1rem;border-top:2px solid var(--border);">Total</td><td style="padding:1rem;font-weight:900;font-size:1.125rem;color:var(--primary);border-top:2px solid var(--border);">${{ number_format($order->total, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="admin-card">
            <div class="admin-card-header"><h3>📍 Shipping Address</h3></div>
            <div class="admin-card-body">
                <p><strong>{{ $order->full_name }}</strong></p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                <p>{{ $order->country }}</p>
                @if($order->phone)<p style="margin-top:.5rem;">📞 {{ $order->phone }}</p>@endif
                <p>✉️ {{ $order->email }}</p>
                @if($order->notes)
                    <div style="margin-top:1rem;padding:1rem;background:var(--bg);border-radius:var(--radius);border:1px solid var(--border);">
                        <strong style="font-size:.875rem;">Notes:</strong>
                        <p style="font-size:.875rem;color:var(--text-secondary);margin-top:.25rem;">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div>
        {{-- Update Status --}}
        <div class="admin-card" style="margin-bottom:1.5rem;">
            <div class="admin-card-header"><h3>Update Status</h3></div>
            <div class="admin-card-body">
                <div style="margin-bottom:1rem;">
                    <span class="status-badge status-{{ $order->status }}" style="font-size:.875rem;padding:.375rem 1rem;">
                        Current: {{ ucfirst($order->status) }}
                    </span>
                </div>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <select name="status" class="form-control">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                </form>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="admin-card" style="margin-bottom:1.5rem;">
            <div class="admin-card-header"><h3>👤 Customer</h3></div>
            <div class="admin-card-body">
                @if($order->user)
                    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
                        <img src="{{ $order->user->avatar_url }}" style="width:44px;height:44px;border-radius:50%;" alt="">
                        <div>
                            <div style="font-weight:600;">{{ $order->user->name }}</div>
                            <div style="font-size:.8rem;color:var(--text-muted);">{{ $order->user->email }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-outline btn-sm btn-block">View Customer Profile</a>
                @else
                    <p style="color:var(--text-muted);">Guest order</p>
                @endif
            </div>
        </div>

        {{-- Order Info --}}
        <div class="admin-card">
            <div class="admin-card-header"><h3>Order Info</h3></div>
            <div class="admin-card-body">
                <div style="display:flex;flex-direction:column;gap:.625rem;font-size:.875rem;">
                    <div class="flex justify-between"><span style="color:var(--text-muted);">Order #</span><span>{{ $order->order_number }}</span></div>
                    <div class="flex justify-between"><span style="color:var(--text-muted);">Date</span><span>{{ $order->created_at->format('M d, Y') }}</span></div>
                    <div class="flex justify-between"><span style="color:var(--text-muted);">Payment</span><span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></div>
                    <div class="flex justify-between"><span style="color:var(--text-muted);">Payment Status</span><span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
