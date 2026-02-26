<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | @yield('title', 'Dashboard') | E-Commerce Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                ⚙️ <span>Admin</span> Panel
            </a>
            <div class="navbar-menu" style="display:flex;gap:0.25rem;">
                <a href="{{ route('home') }}" style="color:rgba(255,255,255,.7);padding:.5rem .875rem;border-radius:var(--radius-sm);font-size:.875rem;font-weight:500;">← View Store</a>
            </div>
            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode"></button>
                <div class="dropdown">
                    <button style="display:flex;align-items:center;gap:.5rem;color:rgba(255,255,255,.8);padding:.5rem .75rem;border-radius:var(--radius-sm);">
                        <img src="{{ auth()->user()->avatar_url }}" class="user-avatar" alt="">
                        <span style="font-size:.875rem;font-weight:600;color:white;">{{ auth()->user()->name }}</span>
                        <span style="color:rgba(255,255,255,.6);font-size:.75rem;">▼</span>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('user.settings') }}" class="dropdown-item">⚙️ My Settings</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item danger">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div style="position:fixed;top:80px;right:1.25rem;z-index:9999;max-width:380px;">
        @if(session('success'))
            <div class="alert alert-success fade-in" data-dismiss="4000">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error fade-in" data-dismiss="5000">❌ {{ session('error') }}</div>
        @endif
    </div>

    <div style="padding-top:var(--nav-height);">
        <div class="admin-layout">
            {{-- Sidebar --}}
            <aside class="admin-sidebar">
                <nav>
                    <ul class="sidebar-nav">
                        <li class="sidebar-section-label">Main</li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <span class="sidebar-icon">📊</span> Dashboard
                            </a>
                        </li>

                        <li class="sidebar-section-label">Catalog</li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <span class="sidebar-icon">📦</span> Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <span class="sidebar-icon">🏷️</span> Categories
                            </a>
                        </li>

                        <li class="sidebar-section-label">Sales</li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <span class="sidebar-icon">🛒</span> Orders
                            </a>
                        </li>

                        <li class="sidebar-section-label">Users</li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <span class="sidebar-icon">👥</span> Users
                            </a>
                        </li>

                        <li class="sidebar-section-label">Store</li>
                        <li>
                            <a href="{{ route('home') }}" class="sidebar-link">
                                <span class="sidebar-icon">🏪</span> View Store
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            {{-- Main Content --}}
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
