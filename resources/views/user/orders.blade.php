@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('user.dashboard') }}">Dashboard</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">My Orders</span>
        </div>
        <h1>📦 My Orders</h1>
    </div>
</div>

<div class="container">
    @if($orders->isEmpty())
        <div class="empty-state card">
            <div class="card-body">
                <div class="empty-state-icon">📦</div>
                <h3>No orders yet</h3>
                <p>Start shopping to see your orders here.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    @else
        <div class="card">
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong style="color:var(--primary);">{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->items->count() ?? '-' }} items</td>
                            <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                            <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td><span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                            <td><a href="{{ route('user.order-detail', $order->order_number) }}" class="btn btn-outline btn-sm">Details →</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->links('partials.pagination') }}
            </div>
        </div>
    @endif
</div>
@endsection
