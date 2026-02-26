<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Pro') | E-Commerce Pro</title>
    <meta name="description" content="@yield('meta_description', 'Premium online shopping destination with thousands of products.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    {{-- Navigation --}}
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                🛒 <span>E</span>Commerce Pro
            </a>

            <ul class="navbar-menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Shop</a></li>
                @foreach(\App\Models\Category::active()->orderBy('sort_order')->take(4)->get() as $cat)
                <li><a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>

            <div class="search-form">
                <form action="{{ route('products.index') }}" method="GET" style="display:flex;width:100%">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                    <button type="submit">🔍</button>
                </form>
            </div>

            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode" title="Toggle dark mode"></button>

                <a href="{{ route('cart.index') }}" class="nav-cart">
                    🛒
                    @php $cartCount = app(\App\Services\CartService::class)->getCount(); @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <div class="dropdown">
                        <button style="display:flex;align-items:center;gap:.5rem;color:rgba(255,255,255,.8);padding:.5rem .75rem;border-radius:var(--radius-sm);transition:all var(--transition);" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='transparent'">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="user-avatar">
                            <span style="font-size:.875rem;font-weight:600;color:white">{{ auth()->user()->name }}</span>
                            <span style="color:rgba(255,255,255,.6);font-size:.75rem">▼</span>
                        </button>
                        <div class="dropdown-menu">
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">⚙️ Admin Panel</a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a href="{{ route('user.dashboard') }}" class="dropdown-item">📊 Dashboard</a>
                            <a href="{{ route('user.orders') }}" class="dropdown-item">📦 My Orders</a>
                            <a href="{{ route('user.settings') }}" class="dropdown-item">⚙️ Settings</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.4);font-size:.875rem;">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div style="position:fixed;top:80px;right:1.25rem;z-index:9999;max-width:380px;width:calc(100% - 2.5rem);">
        @if(session('success'))
            <div class="alert alert-success fade-in" data-dismiss="4000">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error fade-in" data-dismiss="5000">❌ {{ session('error') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning fade-in" data-dismiss="4000">⚠️ {{ session('warning') }}</div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="brand-name">🛒 ECommerce Pro</div>
                    <p>Your premium online shopping destination. Discover thousands of products with amazing deals and fast delivery.</p>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Shop</a></li>
                        @auth
                            <li><a href="{{ route('user.orders') }}">My Orders</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Categories</h4>
                    <ul>
                        @foreach(\App\Models\Category::active()->orderBy('sort_order')->take(5)->get() as $cat)
                            <li><a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <ul>
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('user.settings') }}">Settings</a></li>
                        @endauth
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} ECommerce Pro. All rights reserved.</span>
                <span>Built with ❤️ using Laravel</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
