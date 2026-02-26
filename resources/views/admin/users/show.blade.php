@extends('layouts.admin')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">👤 {{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">← Back to Users</a>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start;">
    {{-- Profile Card --}}
    <div class="admin-card">
        <div class="admin-card-body" style="text-align:center;">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:90px;height:90px;border-radius:50%;object-fit:cover;margin:0 auto 1rem;border:3px solid var(--primary);">
            <h3 style="font-weight:700;margin-bottom:.25rem;">{{ $user->name }}</h3>
            <p style="color:var(--text-muted);font-size:.875rem;margin-bottom:1rem;">{{ $user->email }}</p>
            <span class="status-badge" style="background:{{ $user->is_admin ? '#e0e7ff' : '#f1f5f9' }};color:{{ $user->is_admin ? '#3730a3' : '#475569' }};">
                {{ $user->is_admin ? '⚙️ Admin' : '👤 Customer' }}
            </span>
            <div style="margin-top:1.25rem;display:flex;flex-direction:column;gap:.5rem;font-size:.875rem;text-align:left;">
                <div class="flex justify-between"><span style="color:var(--text-muted);">Total Spent</span><strong>${{ number_format($totalSpent, 2) }}</strong></div>
                <div class="flex justify-between"><span style="color:var(--text-muted);">Orders</span><strong>{{ $user->orders->count() }}</strong></div>
                <div class="flex justify-between"><span style="color:var(--text-muted);">Joined</span><span>{{ $user->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span style="color:var(--text-muted);">Verified</span><span style="color:{{ $user->email_verified_at ? 'var(--accent)' : 'var(--danger)' }};">{{ $user->email_verified_at ? '✓ Yes' : '✗ No' }}</span></div>
                @if($user->phone)<div class="flex justify-between"><span style="color:var(--text-muted);">Phone</span><span>{{ $user->phone }}</span></div>@endif
            </div>
            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" style="margin-top:1.25rem;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-outline btn-block btn-sm" data-confirm="Change this user's role?">
                    {{ $user->is_admin ? 'Revoke Admin Role' : 'Grant Admin Role' }}
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Orders --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3>Order History</h3></div>
        @if($user->orders->isEmpty())
            <div style="padding:2rem;text-align:center;color:var(--text-muted);">No orders yet.</div>
        @else
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->orders->take(10) as $order)
                        <tr>
                            <td><strong style="color:var(--primary);">{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">View →</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
