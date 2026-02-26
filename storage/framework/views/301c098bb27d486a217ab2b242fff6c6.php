<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin | <?php echo $__env->yieldContent('title', 'Dashboard'); ?> | E-Commerce Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="navbar-brand">
                ⚙️ <span>Admin</span> Panel
            </a>
            <div class="navbar-menu" style="display:flex;gap:0.25rem;">
                <a href="<?php echo e(route('home')); ?>" style="color:rgba(255,255,255,.7);padding:.5rem .875rem;border-radius:var(--radius-sm);font-size:.875rem;font-weight:500;">← View Store</a>
            </div>
            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode"></button>
                <div class="dropdown">
                    <button style="display:flex;align-items:center;gap:.5rem;color:rgba(255,255,255,.8);padding:.5rem .75rem;border-radius:var(--radius-sm);">
                        <img src="<?php echo e(auth()->user()->avatar_url); ?>" class="user-avatar" alt="">
                        <span style="font-size:.875rem;font-weight:600;color:white;"><?php echo e(auth()->user()->name); ?></span>
                        <span style="color:rgba(255,255,255,.6);font-size:.75rem;">▼</span>
                    </button>
                    <div class="dropdown-menu">
                        <a href="<?php echo e(route('user.settings')); ?>" class="dropdown-item">⚙️ My Settings</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item danger">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    
    <div style="position:fixed;top:80px;right:1.25rem;z-index:9999;max-width:380px;">
        <?php if(session('success')): ?>
            <div class="alert alert-success fade-in" data-dismiss="4000">✅ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-error fade-in" data-dismiss="5000">❌ <?php echo e(session('error')); ?></div>
        <?php endif; ?>
    </div>

    <div style="padding-top:var(--nav-height);">
        <div class="admin-layout">
            
            <aside class="admin-sidebar">
                <nav>
                    <ul class="sidebar-nav">
                        <li class="sidebar-section-label">Main</li>
                        <li>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                                <span class="sidebar-icon">📊</span> Dashboard
                            </a>
                        </li>

                        <li class="sidebar-section-label">Catalog</li>
                        <li>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                                <span class="sidebar-icon">📦</span> Products
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                                <span class="sidebar-icon">🏷️</span> Categories
                            </a>
                        </li>

                        <li class="sidebar-section-label">Sales</li>
                        <li>
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                                <span class="sidebar-icon">🛒</span> Orders
                            </a>
                        </li>

                        <li class="sidebar-section-label">Users</li>
                        <li>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                                <span class="sidebar-icon">👥</span> Users
                            </a>
                        </li>

                        <li class="sidebar-section-label">Store</li>
                        <li>
                            <a href="<?php echo e(route('home')); ?>" class="sidebar-link">
                                <span class="sidebar-icon">🏪</span> View Store
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            
            <main class="admin-content">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/layouts/admin.blade.php ENDPATH**/ ?>