<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'E-Commerce Pro'); ?> | E-Commerce Pro</title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Premium online shopping destination with thousands of products.'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">
                🛒 <span>E</span>Commerce Pro
            </a>

            <ul class="navbar-menu">
                <li><a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo e(route('products.index')); ?>" class="<?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">Shop</a></li>
                <?php $__currentLoopData = \App\Models\Category::active()->orderBy('sort_order')->take(4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('products.index', ['category' => $cat->slug])); ?>"><?php echo e($cat->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="search-form">
                <form action="<?php echo e(route('products.index')); ?>" method="GET" style="display:flex;width:100%">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">🔍</button>
                </form>
            </div>

            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode" title="Toggle dark mode"></button>

                <a href="<?php echo e(route('cart.index')); ?>" class="nav-cart">
                    🛒
                    <?php $cartCount = app(\App\Services\CartService::class)->getCount(); ?>
                    <?php if($cartCount > 0): ?>
                        <span class="cart-badge"><?php echo e($cartCount); ?></span>
                    <?php endif; ?>
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <div class="dropdown">
                        <button style="display:flex;align-items:center;gap:.5rem;color:rgba(255,255,255,.8);padding:.5rem .75rem;border-radius:var(--radius-sm);transition:all var(--transition);" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='transparent'">
                            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="user-avatar">
                            <span style="font-size:.875rem;font-weight:600;color:white"><?php echo e(auth()->user()->name); ?></span>
                            <span style="color:rgba(255,255,255,.6);font-size:.75rem">▼</span>
                        </button>
                        <div class="dropdown-menu">
                            <?php if(auth()->user()->is_admin): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="dropdown-item">⚙️ Admin Panel</a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="dropdown-item">📊 Dashboard</a>
                            <a href="<?php echo e(route('user.orders')); ?>" class="dropdown-item">📦 My Orders</a>
                            <a href="<?php echo e(route('user.settings')); ?>" class="dropdown-item">⚙️ Settings</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item danger">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.4);font-size:.875rem;">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-secondary btn-sm">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <div style="position:fixed;top:80px;right:1.25rem;z-index:9999;max-width:380px;width:calc(100% - 2.5rem);">
        <?php if(session('success')): ?>
            <div class="alert alert-success fade-in" data-dismiss="4000">✅ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-error fade-in" data-dismiss="5000">❌ <?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="alert alert-warning fade-in" data-dismiss="4000">⚠️ <?php echo e(session('warning')); ?></div>
        <?php endif; ?>
    </div>

    
    <main class="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
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
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">Shop</a></li>
                        <?php if(auth()->guard()->check()): ?>
                            <li><a href="<?php echo e(route('user.orders')); ?>">My Orders</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Categories</h4>
                    <ul>
                        <?php $__currentLoopData = \App\Models\Category::active()->orderBy('sort_order')->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('products.index', ['category' => $cat->slug])); ?>"><?php echo e($cat->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <ul>
                        <?php if(auth()->guard()->guest()): ?>
                            <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                            <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                        <?php endif; ?>
                        <?php if(auth()->guard()->check()): ?>
                            <li><a href="<?php echo e(route('user.dashboard')); ?>">Dashboard</a></li>
                            <li><a href="<?php echo e(route('user.settings')); ?>">Settings</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(route('cart.index')); ?>">Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© <?php echo e(date('Y')); ?> ECommerce Pro. All rights reserved.</span>
                <span>Built with ❤️ using Laravel</span>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/layouts/app.blade.php ENDPATH**/ ?>