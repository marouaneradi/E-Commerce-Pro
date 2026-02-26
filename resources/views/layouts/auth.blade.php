<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | E-Commerce Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">🛒 <span>E</span>Commerce Pro</a>
            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode"></button>
                <a href="{{ route('home') }}" class="btn btn-ghost" style="color:rgba(255,255,255,.8);">← Back to Store</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="auth-wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>
