@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">👥 Users</h1>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="{{ route('admin.users.index') }}" method="GET" style="display:flex;gap:.75rem;">
            <div class="table-search">
                <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
                <button type="submit">🔍</button>
            </div>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Orders</th>
                    <th>Verified</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <img src="{{ $user->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="">
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ $user->is_admin ? '#e0e7ff' : '#f1f5f9' }};color:{{ $user->is_admin ? '#3730a3' : '#475569' }};">
                            {{ $user->is_admin ? '⚙️ Admin' : '👤 Customer' }}
                        </span>
                    </td>
                    <td>{{ $user->orders_count }}</td>
                    <td>
                        <span style="color:{{ $user->email_verified_at ? 'var(--accent)' : 'var(--danger)' }};font-weight:600;">
                            {{ $user->email_verified_at ? '✓' : '✗' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.375rem;">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline btn-sm">View</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-ghost btn-sm" data-confirm="Change this user's role?">
                                    {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination">{{ $users->links('partials.pagination') }}</div>
    </div>
</div>
@endsection
