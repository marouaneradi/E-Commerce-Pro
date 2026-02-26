@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">📊 Dashboard</h1>
    <span style="font-size:.875rem;color:var(--text-muted);">{{ now()->format('l, F j, Y') }}</span>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">🛒</div>
        <div class="stat-info">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-change">{{ $stats['pending_orders'] }} pending</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success">💰</div>
        <div class="stat-info">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">${{ number_format($stats['total_revenue'], 0) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon secondary">📦</div>
        <div class="stat-info">
            <div class="stat-label">Products</div>
            <div class="stat-value">{{ number_format($stats['total_products']) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon info">👥</div>
        <div class="stat-info">
            <div class="stat-label">Customers</div>
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger">⏳</div>
        <div class="stat-info">
            <div class="stat-label">Pending Orders</div>
            <div class="stat-value">{{ number_format($stats['pending_orders']) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon primary">🏷️</div>
        <div class="stat-info">
            <div class="stat-label">Categories</div>
            <div class="stat-value">{{ number_format($stats['total_categories']) }}</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;">
    {{-- Recent Orders --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td><strong style="color:var(--primary);">{{ $order->order_number }}</strong><br><small style="color:var(--text-muted);">{{ $order->created_at->diffForHumans() }}</small></td>
                        <td>{{ $order->user->name ?? $order->first_name }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">→</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Top Products</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">All</a>
        </div>
        <div class="admin-card-body" style="padding:0;">
            @foreach($topProducts as $product)
            <div style="display:flex;align-items:center;gap:.75rem;padding:.875rem 1.25rem;border-bottom:1px solid var(--border);">
                @if($product->image)
                    <img src="{{ $product->image_url }}" style="width:40px;height:40px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);" alt="">
                @else
                    <div style="width:40px;height:40px;border-radius:var(--radius-sm);background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:1rem;">📦</div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->name }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $product->order_items_count }} sold</div>
                </div>
                <div style="font-weight:700;font-size:.875rem;">${{ number_format($product->price, 2) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
