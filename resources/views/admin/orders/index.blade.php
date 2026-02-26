@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">🛒 Orders</h1>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="{{ route('admin.orders.index') }}" method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <div class="table-search">
                <input type="text" name="search" placeholder="Order # or email..." value="{{ request('search') }}">
                <button type="submit">🔍</button>
            </div>
            <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong style="color:var(--primary);">{{ $order->order_number }}</strong></td>
                    <td>
                        <div>{{ $order->first_name }} {{ $order->last_name }}</div>
                        <div style="font-size:.78rem;color:var(--text-muted);">{{ $order->email }}</div>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                    <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td><span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">View →</a></td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination">{{ $orders->links('partials.pagination') }}</div>
    </div>
</div>
@endsection
